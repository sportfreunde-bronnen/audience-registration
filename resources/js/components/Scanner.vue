<template>
    <div>
        <div class="bg-gray-800 text-white px-2 py-1 text-center mb-2 rounded">
            Eingecheckt: {{ this.amountCheckedIn }} | Offen: {{ this.amountNotCheckedIn }}
        </div>
        <div class="flex flex-col content-center" :class="containerClass">
            <div>
                <input ref="code" v-on:keyup.enter="onEnter" type="text" class="w-full text-center my-2 py-3 bg-gray-500 text-white text-xl" v-model="code"/>
            </div>
            <div v-if="this.sendCode" class="mb-3 text-center font-bold text-lg">{{ this.sendCode }}</div>
            <div v-if="this.message" class="text-center font-bold text-sm mb-3 px-3">{{ this.message }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Scanner",
        props: [
            'initCountCheckedIn',
            'initCountNotCheckedIn'
        ],
        data() {
            return {
                inProgress: false,
                code: "",
                sendCode: "",
                inToggle: false,
                inToggleSuccess: false,
                inToggleFailure: false,
                mode: 1, // 1 = Entry; 2 = Exit,
                message: null,
                amountCheckedIn: this.initCountCheckedIn,
                amountNotCheckedIn: this.initCountNotCheckedIn
            }
        },
        mounted() {
            this.$refs.code.focus();
            this.$refs.code.click();

            document.addEventListener('touchstart', function enableNoSleep() {
                document.removeEventListener('touchstart', enableNoSleep, false);
                window.noSleep.enable();
            }, false);
        },
        destroyed() {
            window.noSleep.disable();
        },
        computed: {
            containerClass: function() {
                return {
                    'bg-green-600': this.inToggle && this.inToggleSuccess,
                    'bg-red-600': this.inToggle && this.inToggleFailure,
                    'text-white': this.inToggle,
                    'bg-gray-200': !this.inToggle
                }
            }
        },
        methods: {
            onEnter() {
                this.handleCode();
            },
            handleCode() {

                this.resetToggle();

                const uri = '/' + window.location.pathname.substr(1);

                this.sendCode = this.code;

                axios.post(uri, { secret: this.code, mode: this.mode })
                .then((res) => {

                    this.message = res.data.message;

                    this.lastCode = null;
                    this.inToggle = true;

                    this.amountCheckedIn = res.data.countCheckedIn;
                    this.amountNotCheckedIn = res.data.countNotCheckedIn;

                    this.inProgress = false;

                    if (res.data.status === 0) {
                        this.inToggleSuccess = true;
                        this.code = "";
                    } else {
                        this.inToggleFailure = true;
                        this.code = "";
                    }
                })
                .catch((err) => {
                    this.message = 'Dieser Code ist unbekannt!';
                    this.inProgress = false;
                    this.inToggleFailure = true;
                    this.inToggle = true;
                    this.code = "";
                })
            },
            resetToggle() {
                this.message = null;
                this.inToggle = false;
                this.inToggleFailure = false;
                this.inToggleSuccess = false;
            }
        }
    }
</script>
