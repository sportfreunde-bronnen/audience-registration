<template>
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
        <div v-if="this.activeCamera && this.camerasInitiated" id="reader" class="bg-gray-200 w-100 mx-auto my-3" style="width: 300px;"/>
        <div v-if="this.code" class="mb-3 text-center font-bold text-lg">{{ this.code }}</div>
    </div>
</template>

<script>
    export default {
        name: "Scanner",
        data() {
            return {
                reader: new Html5Qrcode("reader"),
                camerasInitiated: false,
                scannerActive: false,
                inProgress: false,
                cameras: null,
                activeCamera: null,
                lastCode: null,
                codeMatchCount: 0,
                code: null,
                inToggle: false
            }
        },
        mounted() {
        },
        computed: {
            containerClass: function() {
                return {
                    'bg-green-600': this.inToggle,
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
                    .catch(err => {
                        // Start failed, handle it. For example,
                        console.log(`Unable to start scanning, error: ${err}`);
                    });
            },
            handleCode(code) {
                const obj = this;
                obj.code = code;
                console.log("Handle code", code);
                setTimeout(() => {
                    obj.lastCode = null;
                    obj.codeMatchCount = 0;
                    obj.inProgress = false;
                    obj.inToggle = true;
                    setTimeout(() => {
                        obj.inToggle = false;
                        obj.code = null;
                    }, 150);
                }, 1000);
            },
            toggleSuccess() {

            }
        }
    }
</script>
