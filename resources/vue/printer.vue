<template>
<div>
    <p>Translation key <code>PRINTER_EXAMPLE</code> from <code>printer/resources/lang/**/js.php</code>: {{$lang.PRINTER_EXAMPLE}}</p>
    <button class="form-builder__send btn" @click="testDebug">Test console log for debug</button>
    <p>From config JS file: {{this.example_data}}</p>
    <p>Example function: {{this.exampleFromFunction}}</p>
    <p>
        <button class="form-builder__send btn" @click="testLoading">Test loading</button>
        <span v-if="isLoading">is loading...</span>
    </p>
</div>
</template>

<script>
import printerMixin from '../js/mixins/printer'
import {consoleDebug} from '../js/modules/helpers'

let _uniqSectionId = 0;

export default {

    name: 'printer',

    mixins: [ printerMixin ],

    props: {
        name: {
            type: String,
            default() {
                return `printer-${ _uniqSectionId++ }`
            }
        },

        default: Object,

        storeData: String,
    },


    computed: {
        printer() {
            return this.$store.state.printer[this.name]
        },

        isLoading() {
            return this.printer && this.printer.isLoading
        },
    },

    created() {

        let data = this.storeData ? this.$store.state[this.storeData] : (this.default || {})

        this.$store.commit('printer/create', {
            name: this.name,
            data
        })
    },

    mounted() {

    },

    methods: {
        testDebug(){
            consoleDebug('message', ['data1'], ['data2'])
        },

        testLoading(){
            if ( this.isLoading) return;

            AWEMA.emit(`printer::${this.name}:before-test-loading`)

            this.$store.dispatch('printer/testLoading', {
                name: this.name
            }).then( data => {
                consoleDebug('data', data);
                this.$emit('success', data.data)
                this.$store.$set(this.name, this.$get(data, 'data', {}))
            })
        }
    },


    beforeDestroy() {

    }
}
</script>
