<?php

namespace DGTLONE;

class Chunky
{
    private $type;
    private $id;
    private $target;

    /**
     * Constructor
     */

    public function __construct()
    {
        // Get the target path
        $target_path = $_SERVER['HTTP_X_TARGET_PATH'];

        // Check if the target path is the site root
        if ($target_path === 'site')
        {
            $this->target = kirby()->site();
        }
        else
        {
            // Get the target type
            $this->type = \Kirby\Toolkit\Str::before($target_path, '/');

            // Get the target id
            $this->id = \Kirby\Toolkit\Str::after($target_path, '/') ?? null;

            // Get the target page
            $this->target = \Kirby\Cms\Find::page($this->id);
        }

        // Server the tus server endpoint
        $this->serveTusServer();
    }

    /**
     * Serve the tus server endpoint
     */

    private function serveTusServer()
    {
        $scope = $this;

        $tus = new \TusPhp\Tus\Server();
        $tus->setUploadKey(\sha1($tus->getRequest()->extractFileName()));
        $tus->setApiPath('/' . kirby()->option('api.slug', 'api') . '/dgtlone/chunky/upload');
        $tus->setUploadDir($this->chunksDirectory());
        $tus->event()->addListener('tus-server.upload.complete', function (\TusPhp\Events\TusEvent $event) use ($scope)
        {
            $scope->processFile($event->getFile()->getFilePath());
        });

        $response = $tus->serve();
        $response->send();
    }

    /**
     * Move the uploaded file to the target ressource (site or page with id)
     *
     * @param string $tempFilePath
     * @return void
     */

    private function processFile(string $tempFilePath)
    {
        // Create file at target
        \Kirby\Cms\File::create([
            'source' => $tempFilePath,
            'parent' => $this->target,
        ]);

        // Remove file from temp directory
        \Kirby\Filesystem\F::remove($tempFilePath);
    }

    /**
     * Create or get the temporary chunk directory for uploads
     *
     * @return string
     */

    private function chunksDirectory(): string
    {
        // Define the temp directory path
        $temp_directory = $this->target->contentFileDirectory() . '/.dgtlone_chunky';

        // Create the temp directory if it doesn't exist
        if (!\file_exists($temp_directory))
        {
            \Kirby\Filesystem\Dir::make($temp_directory);
        }

        return $temp_directory;
    }

    /**
     * Get the chunk size in bytes
     *
     * @return int
     */

    public static function chunkSize(): int
    {
        // Define allowed chunk sizes
        $max_filesizes = [];

        // Get the max allowed upload file size setting from php.ini in bytes
        $max_filesizes[] = \Kirby\Toolkit\Str::toBytes(\ini_get('upload_max_filesize'));
        $max_filesizes[] = \Kirby\Toolkit\Str::toBytes(\ini_get('post_max_size'));

        // Check if server is behind the cloudflare proxy
        if (isset($_SERVER['HTTP_CF_CONNECTING_IP']))
        {
            $max_filesizes[] = \Kirby\Toolkit\Str::toBytes('100M');
        }

        // Get the smallest possible chunk size
        $max_filesize = (int) \floor(\min($max_filesizes) * 0.9);

        // Check if the chunk size is set in the plugin options
        $chunk_size_setting = kirby()->option('dgtlone.kirby-uploader.chunk_size', null);
        if ($chunk_size_setting !== null)
        {
            // Get the chunk size from the plugin options in bytes
            $chunk_size = \Kirby\Toolkit\Str::toBytes($chunk_size_setting);

            // Check if the chunk size is smaller than the max file size
            if ($chunk_size < $max_filesize)
            {
                return $chunk_size;
            }
        }

        // If possible, set the chunk size to 5MB for efficient resumable uploads
        $recommended_size = \Kirby\Toolkit\Str::toBytes('5M');
        $max_filesize = ($recommended_size <= $max_filesize) ? $recommended_size : $max_filesize;

        // Return 90% of the max file size (to be sure)
        return $max_filesize;
    }

    /**
     * Returns the required API routes for Chunky
     *
     * @return array
     */

    public static function apiRoutes(): array
    {
        return [
            /**
             * Serves the tus protocol for file uploads
             */
            [
                'pattern' => 'dgtlone/chunky/upload(:all)',
                'method' => 'CONNECT|DELETE|GET|HEAD|OPTIONS|PATCH|POST|PUT|TRACE',
                'action'  => function ()
                {
                    return new \DGTLONE\Chunky();
                }
            ],
            /**
             * Provides the currently available chunk size in bytes for each upload
             */
            [
                'pattern' => 'dgtlone/chunky/chunk_size',
                'method' => 'GET',
                'action'  => function ()
                {
                    return [
                        'bytes' => \DGTLONE\Chunky::chunkSize()
                    ];
                }
            ]
        ];
    }
}
