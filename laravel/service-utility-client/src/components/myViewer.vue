<template>
    <div class="ql-container ql-snow" v-viewer="{ movable: true, navbar: false, toolbar:false }">
        <div class="ql-editor"
             v-html="html">
        </div>
    </div>
</template>
<script>
import 'quill/dist/quill.snow.css'
export default {
  name: 'myViewer',
  props: [ 'html' ]
}
</script>
