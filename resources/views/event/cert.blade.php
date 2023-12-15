<div class="modal-header">
    <h4 class="modal-title">Completion Form Certificate</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    {{-- <div style="width:700px; height:600px; padding:20px; text-align:center; border: 10px solid #ffc400;background-color: white;"
        id="cert">
        <div style="width:650px; height:550px; padding:20px; text-align:center; border: 5px solid #ffc400">
            <span style="font-size:50px; font-weight:bold">Volunteer Certificate</span>
            <br><br>
            <span style="font-size:25px"><i>This is to certify that</i></span>
            <br><br>
            <span style="font-size:30px"><b>{{ $record->name }}</b></span><br /><br />
            <span style="font-size:25px"><i>has contribute to</i></span> <br /><br />
            <span style="font-size:30px"><b>{{ $record->volunteer->event->event_name }}</b></span>
            <br /><br /><br /><br />
            <span style="font-size:25px"><i>Dated</i></span><br>
            <span style="font-size:30px"><b>{{ $record->created_at->format('d/m/Y') }}</b></span>
        </div>
    </div> --}}

    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans|Pinyon+Script|Rochester');

        .cursive {
            font-family: 'Pinyon Script', cursive;
        }

        .sans {
            font-family: 'Open Sans', sans-serif;
        }

        .bold {
            font-weight: bold;
        }

        .block {
            display: block;
        }

        .underline {
            border-bottom: 1px solid #777;
            padding: 5px;
            margin-bottom: 15px;
        }

        .margin-0 {
            margin: 0;
        }

        .padding-0 {
            padding: 0;
        }

        .pm-empty-space {
            height: 40px;
            width: 100%;
        }

        body {
            /* padding: 20px 0; */
            background: #ccc;
        }

        .pm-certificate-container {
            position: relative;
            width: 800px;
            height: 600px;
            background-color: #618597;
            padding: 30px;
            color: #333;
            font-family: 'Open Sans', sans-serif;
            box-shadow: 0 0 5px rgba(0, 0, 0, .5);

            .outer-border {
                width: 794px;
                height: 594px;
                position: absolute;
                left: 50%;
                margin-left: -397px;
                top: 50%;
                margin-top: -297px;
                border: 2px solid #fff;
            }

            .inner-border {
                width: 730px;
                height: 530px;
                position: absolute;
                left: 50%;
                margin-left: -365px;
                top: 50%;
                margin-top: -265px;
                border: 2px solid #fff;
            }

            .pm-certificate-border {
                position: relative;
                width: 720px;
                height: 520px;
                padding: 0;
                border: 1px solid #E1E5F0;
                background-color: rgba(255, 255, 255, 1);
                background-image: none;
                left: 50%;
                margin-left: -360px;
                top: 50%;
                margin-top: -260px;

                .pm-certificate-block {
                    width: 650px;
                    height: 200px;
                    position: relative;
                    left: 50%;
                    margin-left: -325px;
                    top: 70px;
                    margin-top: 0;
                }

                .pm-certificate-header {
                    margin-bottom: 10px;
                }

                .pm-certificate-title {
                    position: relative;
                    top: 40px;

                    h2 {
                        font-size: 34px !important;
                    }
                }

                .pm-certificate-body {
                    padding: 20px;

                    .pm-name-text {
                        font-size: 20px;
                    }
                }

                .pm-earned {
                    margin: 15px 0 20px;

                    .pm-earned-text {
                        font-size: 20px;
                    }

                    .pm-credits-text {
                        font-size: 15px;
                    }
                }

                .pm-course-title {
                    .pm-earned-text {
                        font-size: 20px;
                    }

                    .pm-credits-text {
                        font-size: 15px;
                    }
                }

                .pm-certified {
                    font-size: 12px;

                    .underline {
                        margin-bottom: 5px;
                    }
                }

                .pm-certificate-footer {
                    width: 650px;
                    height: 100px;
                    position: relative;
                    left: 50%;
                    margin-left: -325px;
                    bottom: -105px;
                }
            }
        }
    </style>

    <div class="container pm-certificate-container" id="cert">
        <div class="outer-border"></div>
        <div class="inner-border"></div>

        <div class="pm-certificate-border col-lg-12">
            <div class="row pm-certificate-header">
                <div class="pm-certificate-title cursive col-lg-12 text-center">
                    <h2>Volunteer Certificate</h2>
                </div>
            </div>

            <div class="row pm-certificate-body">

                <div class="pm-certificate-block">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                            <div class="pm-certificate-name underline margin-0 col-lg-8 text-center">
                                <span class="pm-name-text bold">{{ $record->name }}</span>
                            </div>
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                            <div class="pm-earned col-lg-8 text-center">
                                <span class="pm-earned-text padding-0 block cursive">has contribute to</span>
                                <span class="pm-credits-text block bold sans">{{ $record->volunteer->event->event_name }}</span>
                            </div>
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                            <div class="col-lg-12"></div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                            <div class="pm-course-title col-lg-8 text-center">
                                <span class="pm-earned-text block cursive">in</span>
                            </div>
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                            <div class="pm-course-title underline col-lg-8 text-center">
                                <span class="pm-credits-text block bold sans">{{ $record->volunteer->event->event_location }}</span>
                            </div>
                            <div class="col-lg-2"><!-- LEAVE EMPTY --></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12" style="margin-top: 120px;">
                    <div class="row">
                        {{-- <div class="pm-certificate-footer"> --}}
                        <div class="col-lg-4 pm-certified text-center">
                            <span class="pm-credits-text block sans">Fund Raiser</span>
                            <span class="pm-empty-space block underline"><i>{{ $record->volunteer->event->user->first_name }}</i></span>
                            <span class="bold block">{{ $record->volunteer->event->user->username }}</span>
                        </div>
                        <div class="col-lg-4">
                            <!-- LEAVE EMPTY -->
                        </div>
                        <div class="col-lg-4 pm-certified text-center">
                            <span class="pm-credits-text block sans">Date Completed</span>
                            <span class="pm-empty-space block underline"></span>
                            <span class="bold block">{{ $record->created_at->format('d/m/Y') }}</span>
                        </div>
                        {{-- </div> --}}
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="text-center" style="margin: 10px;">
        <button type="button" class="btn btn-success btn-lg" onclick="downloadImage()">
            Download
        </button>
    </div>
</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

<script>
    function downloadImage() {
        const htmlContent = document.getElementById('cert');
        html2canvas(htmlContent).then(function(canvas) {
            // Convert canvas to image
            const imgData = canvas.toDataURL('image/png');

            // Create a temporary link element
            const link = document.createElement('a');
            link.href = imgData;
            link.download = 'cert.png';
            link.click();
        });
    }
</script>
