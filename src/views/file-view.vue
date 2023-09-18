<script>

export default {
    extends: 'k-file-view',
    methods: {
		action(action) {
			switch (action) {
				case "replace":
					this.$refs.upload.open({
						url: this.$urls.api + "/" + this.id,
						accept: "." + this.model.extension + "," + this.model.mime,
						multiple: false,
                        attributes: {
                            replace: true
                        }
					});
					break;
			}
		},
    }
}

</script>