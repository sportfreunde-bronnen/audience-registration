<template>
    <div>
        <div class="bg-gray-800 text-white px-2 py-1 text-center mb-2 rounded">
            Eingecheckt: {{ this.amountCheckedIn }} | Offen: {{ this.amountNotCheckedIn }}
        </div>
        <div class="flex flex-col content-center" :class="containerClass">
            <div class="flex w-100">
                <button v-if="!this.camerasInitiated && !this.cameras" class="bg-gray-800 text-white rounded px-2 py-3 w-full" v-on:click="initCameras">
                    Kamera(s) initialisieren
                </button>
                <button v-if="this.camerasInitiated && !this.scannerActive" class="bg-gray-800 text-white rounded px-2 py-3 w-full" v-on:click="startScanning">
                    Scanner starten
                </button>
            </div>
            <div class="my-5" v-if="!this.camerasInitiated && this.cameras">
                <button v-for="camera in this.cameras" class="bg-gray-800 text-white rounded px-2 py-3 w-full my-2" v-on:click="setActiveCamera(camera);">
                    {{ camera.label }}
                </button>
            </div>
            <div v-if="this.activeCamera && this.camerasInitiated" id="reader" class="bg-gray-200 w-100 mx-auto my-3" style="width: 250px;"/>
            <div v-if="this.code" class="mb-3 text-center font-bold text-lg">{{ this.code }}</div>
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
                reader: new Html5Qrcode("reader", false),
                camerasInitiated: false,
                scannerActive: false,
                inProgress: false,
                cameras: null,
                activeCamera: null,
                lastCode: null,
                codeMatchCount: 0,
                code: null,
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
            setActiveCamera(camera) {
                this.activeCamera = camera;
                this.camerasInitiated = true;
                this.cameras = null;
            },
            initCameras() {
                var obj = this;
                Html5Qrcode.getCameras().then(devices => {
                    if (devices && devices.length) {
                        //devices.push(devices[0]);
                        obj.cameras = devices;
                        if (devices.length === 1) {
                            obj.activeCamera = devices[0];
                            obj.camerasInitiated = true;
                        }
                    }
                }).catch(err => {
                    // handle err
                });
            },
            startScanning() {
                const obj = this;
                this.scannerActive = true;
                obj.reader.start(
                    obj.activeCamera.id,
                    {
                        fps: 10,
                        qrbox: 250
                    },
                    qrCodeMessage => {
                        if (obj.inProgress) {
                            return;
                        }
                        const code = qrCodeMessage;
                        if (code.length === 16) {
                            if (code === obj.lastCode) {
                                obj.codeMatchCount++;
                                if (obj.codeMatchCount === 2) {
                                    obj.inProgress = true;
                                    obj.handleCode(code);
                                }
                            } else {
                                obj.lastCode = code;
                                obj.codeMatchCount = 0;
                            }
                        }
                    }
                    )
                    .catch(err => {});
            },
            handleCode(code) {

                this.resetToggle();

                const obj = this;
                obj.code = code;

                const uri = '/' + window.location.pathname.substr(1);

                axios.post(uri, { secret: code, mode: this.mode })
                .then((res) => {

                    obj.message = res.data.message;

                    obj.lastCode = null;
                    obj.codeMatchCount = 0;
                    obj.inToggle = true;

                    obj.amountCheckedIn = res.data.countCheckedIn;
                    obj.amountNotCheckedIn = res.data.countNotCheckedIn;

                    setTimeout(() => {
                        obj.inProgress = false;
                    }, 1000);

                    if (res.data.status === 0) {
                        obj.inToggleSuccess = true;
                    } else {
                        obj.inToggleFailure = true;
                    }
                })
                .catch((err) => {})
            },
            resetToggle() {
                this.message = null;
                this.inToggle = false;
                this.inToggleFailure = false;
                this.inToggleSuccess = false;
                this.code = null;
            }
        }
    }
</script>
