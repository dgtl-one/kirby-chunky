
/**
 * Kirby Chunky
 *
 * @version 1.0.0
 * @link https://github.com
 * @license MIT
 * @author DGTL.ONE
 */

import upload from "./forms/upload.vue";
import fileView from "./views/file-view.vue";

panel.plugin('dgtlone/kirby-chunky', {
    components: {
        'k-upload': upload,
        'k-file-view': fileView,
    },
});