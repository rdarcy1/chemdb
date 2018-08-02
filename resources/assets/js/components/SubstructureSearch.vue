<template>
    <div class="flex flex-col items-center justify-center">
        <a @click.prevent="toggleEditor" class="cursor-pointer mb-4 no-underline text-blue hover:text-blue-darker">
            {{ showEditor ? '&minus;' : '&plus;' }} search substructure
        </a>

        <form action="/search/substructure" method="POST">
            <input type="hidden" name="_token" :value="csrfToken">
            <div v-show="showEditor">
                <div class="flex justify-center mb-3">
                    <div class="w-screen flex justify-center">
                        <button type="submit" class="bg-grey-lighter border border-white text-grey-dark hover:border-grey hover:text-grey-darkest px-4 py-2 rounded text">Search</button>
                    </div>
                </div>
            </div>

            <div v-show="showEditor">
                <div class="flex justify-center mb-3">
                    <div class="w-screen flex justify-center">
                        <div class="JSDraw"
                             id="mobile-editor"
                             dataformat='molfile'
                             data=""
                             skin="w8"
                             ondatachange="molchange"
                        ></div>
                    </div>
                </div>
            </div>

            <input type="hidden" name="molfile" id="molfile">
        </form>
    </div>
</template>

<script>
    export default {
        props: ['csrf-token'],

        data() {
            return {
                showEditor: false,
                editor: null,
                changed: null,
            }
        },

        methods: {
            toggleEditor() {
                // if this is the first time we open the editor, create the app instance
                if(!this.showEditor &&!this.editor) {
                    this.editor = new JSDraw('mobile-editor');
                }

                // if the editor needs to be closed, we need to hide the 'table' element
                if(this.showEditor) {
                    document.querySelectorAll('table').forEach((table) => {
                        table.style.visibility = 'hidden';
                    });
                } else {
                    document.querySelectorAll('table').forEach((table) => {
                        table.style.visibility = 'visible';
                    });
                }

                // now we toggle the visibility of the editor
                this.showEditor = !this.showEditor;

                this.$emit('substructure-editor', this.showEditor);
            },
        }
    }
</script>

<style>
    #mobile-editor {
        width: 550px;
        height: 350px;
    }

    @media only screen and (max-width: 768px) {
        #mobile-editor {
            width: 320px;
            height: 300px;
            margin-left: 10px;
            margin-right: 10px;
        }
    }
</style>