<script>
import * as tus from "tus-js-client";

export default {
    extends: 'k-upload',
    methods: {
        async upload(files)
        {
            let scope = this;
            let { bytes } = await this.$api.get("dgtlone/chunky/chunk_size");

            this.$refs.dialog.open();
            this.files = [...files];
            this.completed = {};
            this.errors = [];
            this.hasErrors = false;

            if (this.limit)
            {
                this.files = this.files.slice(0, this.limit);
            }

            this.total = this.files.length;
            this.files.forEach((file) =>
            {
                let template = this.options?.attributes?.template ?? "";
                let replace = this.options?.attributes?.replace ?? false;

                let tusUploader = new tus.Upload(file, {
                    endpoint: scope.$urls.api + "/dgtlone/chunky/upload",
                    chunkSize: bytes,
                    retryDelays: [0, 3000, 5000, 10000, 20000],
                    removeFingerprintOnSuccess: true,
                    headers: {
                        "X-CSRF": scope.$system.csrf,
                        "X-Target-Path": scope.$view.path
                    },
                    metadata: {
                        filename: file.name,
                        filetype: file.type,
                        template: template,
                        replace: !!replace
                    },
                    onError: function (error)
                    {
                        scope.errors.push({ file: file, message: error });
                        scope.complete(file, error);
                    },
                    onProgress: function (bytesUploaded, bytesTotal)
                    {
                        var percentage = (bytesUploaded / bytesTotal * 100).toFixed(2);
                        scope.$refs[file.name]?.[0]?.set(percentage);
                    },
                    onSuccess: function ()
                    {
                        scope.complete(file, true);
                    }
                });

                // Resume previous upload if available
                tusUploader.findPreviousUploads().then(function (previousUploads)
                {
                    if (previousUploads.length)
                    {
                        tusUploader.resumeFromPreviousUpload(previousUploads[0]);
                    }

                    tusUploader.start();
                });

                // if there is sort data, increment in the loop for next file
                if (this.options?.attributes?.sort !== undefined)
                {
                    this.options.attributes.sort++;
                }
            });
        },
    }
};
</script>