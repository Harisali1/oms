@extends('front.layouts.Dispatch-layout')

@section('page-title',"Create Order")

@section('css')
    <style>
        h1 {
            text-align: center;
        }

        h2 {
            margin: 0;
        }

        #multi-step-form-container {
            margin-top: 5rem;
        }

        .text-center {
            text-align: center;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .pl-0 {
            padding-left: 0;
        }

        .button {
            padding: 0.7rem 1.5rem;
            border: 1px solid #4361ee;
            background-color: #4361ee;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
        }

        .submit-btn {
            border: 1px solid #0e9594;
            background-color: #0e9594;
        }

        .mt-3 {
            margin-top: 2rem;
        }

        .d-none {
            display: none;
        }

        .form-step {
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            padding: 3rem;
        }

        .font-normal {
            font-weight: normal;
        }

        ul.form-stepper {
            counter-reset: section;
            margin-bottom: 3rem;
        }

        ul.form-stepper .form-stepper-circle {
            position: relative;
        }

        ul.form-stepper .form-stepper-circle span {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translateY(-50%) translateX(-50%);
        }

        .form-stepper-horizontal {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: justify;
            -ms-flex-pack: justify;
            justify-content: space-between;
        }

        ul.form-stepper > li:not(:last-of-type) {
            margin-bottom: 0.625rem;
            -webkit-transition: margin-bottom 0.4s;
            -o-transition: margin-bottom 0.4s;
            transition: margin-bottom 0.4s;
        }

        .form-stepper-horizontal > li:not(:last-of-type) {
            margin-bottom: 0 !important;
        }

        .form-stepper-horizontal li {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            -webkit-box-align: start;
            -ms-flex-align: start;
            align-items: start;
            -webkit-transition: 0.5s;
            transition: 0.5s;
        }

        .form-stepper-horizontal li:not(:last-child):after {
            position: relative;
            -webkit-box-flex: 1;
            -ms-flex: 1;
            flex: 1;
            height: 1px;
            content: "";
            top: 32%;
        }

        .form-stepper-horizontal li:after {
            background-color: #dee2e6;
        }

        .form-stepper-horizontal li.form-stepper-completed:after {
            background-color: #4da3ff;
        }

        .form-stepper-horizontal li:last-child {
            flex: unset;
        }

        ul.form-stepper li a .form-stepper-circle {
            display: inline-block;
            width: 40px;
            height: 40px;
            margin-right: 0;
            line-height: 1.7rem;
            text-align: center;
            background: rgba(0, 0, 0, 0.38);
            border-radius: 50%;
        }

        .form-stepper .form-stepper-active .form-stepper-circle {
            background-color: #4361ee !important;
            color: #fff;
        }

        .form-stepper .form-stepper-active .label {
            color: #4361ee !important;
        }

        .form-stepper .form-stepper-active .form-stepper-circle:hover {
            background-color: #4361ee !important;
            color: #fff !important;
        }

        .form-stepper .form-stepper-unfinished .form-stepper-circle {
            background-color: #f8f7ff;
        }

        .form-stepper .form-stepper-completed .form-stepper-circle {
            background-color: #0e9594 !important;
            color: #fff;
        }

        .form-stepper .form-stepper-completed .label {
            color: #0e9594 !important;
        }

        .form-stepper .form-stepper-completed .form-stepper-circle:hover {
            background-color: #0e9594 !important;
            color: #fff !important;
        }

        .form-stepper .form-stepper-active span.text-muted {
            color: #fff !important;
        }

        .form-stepper .form-stepper-completed span.text-muted {
            color: #fff !important;
        }

        .form-stepper .label {
            font-size: 1rem;
            margin-top: 0.5rem;
        }

        .form-stepper a {
            cursor: default;
        }
    </style>
@stop

@section('content')
    <main id="main" class="page-summary" data-page="summary">
        <div class="pg-container container-fluid">
            <!-- Content Area - [Start] -->
            <div id="main_content_area">
                <div class="row no-gutters">
                    <!-- Sidebar -->
                @include('front.schedule.sidebar')
                <!-- Sidebar -->
                    <aside id="right_content" class="col-12 col-lg-9">
                        <div class="inner">
                            <div class="content_header_wrap">
                                <div class="hgroup divider-after left">
                                    <h1 class="lh-10">OCR</h1>
                                </div>
                            </div>

                            <form method="POST" action="{{ route('schedule.store') }}" class="form-horizontal"
                                  role="form" enctype="multipart/form-data">
                                @csrf
                                <div class="col-md-12">
                                    <h1>Order Creation By Image Proccessing</h1>
                                    <div id="multi-step-form-container">
                                        <!-- Form Steps / Progress Bar -->
                                        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                                            <!-- Step 1 -->
                                            <li class="form-stepper-active text-center form-stepper-list" step="1">
                                                <a class="mx-2">
                                                    <span class="form-stepper-circle">
                                                        <span>1</span>
                                                    </span>
                                                    <div class="label">Basic Details</div>
                                                </a>
                                            </li>
                                            <!-- Step 2 -->
                                            <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                                                <a class="mx-2">
                                                    <span class="form-stepper-circle text-muted">
                                                        <span>2</span>
                                                    </span>
                                                    <div class="label text-muted">Upload Image</div>
                                                </a>
                                            </li>
                                            <!-- Step 3 -->
                                            <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                                                <a class="mx-2">
                                                    <span class="form-stepper-circle text-muted">
                                                        <span>3</span>
                                                    </span>
                                                    <div class="label text-muted">Order Details</div>
                                                </a>
                                            </li>
                                        </ul>
                                        <!-- Step Wise Form Content -->
                                        <form id="userAccountSetupForm" name="userAccountSetupForm"
                                              enctype="multipart/form-data" method="POST">
                                            <!-- Step 1 Content -->
                                            <section id="step-1" class="form-step">
                                                <h2 class="font-normal">Basic Details</h2>
                                                <!-- Step 1 input fields -->
                                                <div class="row d-flex">
                                                    <div class="col-lg-6 col-sm-12 mb-2">
                                                        <p>
                                                            <input placeholder="Name..."
                                                                   class="input-field2 form-control" name="name"
                                                                   id="name">
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12 mb-2">
                                                        <p>
                                                            <input placeholder="email..."
                                                                   class="input-field2 form-control" name="email"
                                                                   id="email">
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12 mb-2">
                                                        <p>
                                                            <input placeholder="phone number..."
                                                                   class="input-field2 form-control" name="number"
                                                                   id="number">
                                                        </p>
                                                    </div>
                                                    <div class="col-lg-6 col-sm-12 mb-2">
                                                        <p>
                                                            <input placeholder=" Address..."
                                                                   class="input-field2 form-control" name="address"
                                                                   id="address">
                                                        </p>
                                                    </div>


                                                </div>
                                                <div class="mt-3">
                                                    <button class="button btn-navigate-form-step" type="button"
                                                            step_number="2">Next
                                                    </button>
                                                </div>
                                            </section>
                                            <!-- Step 2 Content, default hidden on page load. -->
                                            <section id="step-2" class="form-step d-none">
                                                <h2 class="font-normal">Upload Image</h2>
                                                <!-- Step 2 input fields -->
                                                <form method="post"
                                                      enctype="multipart/form-data"
                                                      id="image-processing">
                                                    {{ csrf_field() }}
                                                    <input class="" type="file"
                                                           name="files[]" multiple>
                                                    <input type="button" id="image-extract"
                                                           class="btn-modal btn" onclick="imageExtracting()"
                                                           value="Upload and Extract The Data">
                                                </form>
                                                <div class="mt-3">
                                                    <button class="button btn-navigate-form-step" type="button"
                                                            step_number="1">Prev
                                                    </button>
                                                    <button class="button btn-navigate-form-step" type="button"
                                                            step_number="3">Next
                                                    </button>
                                                </div>
                                            </section>
                                            <!-- Step 3 Content, default hidden on page load. -->
                                            <section id="step-3" class="form-step d-none">
                                                <h2 class="font-normal">Order Details</h2>
                                                <!-- Step 3 input fields -->
                                                <table id="myDataTable" class="display">
                                                    <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Age</th>
                                                        <th>Country</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>John Doe</td>
                                                        <td>25</td>
                                                        <td>USA</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jane Smith</td>
                                                        <td>30</td>
                                                        <td>Canada</td>
                                                    </tr>
                                                    <!-- Add more rows as needed -->
                                                    </tbody>
                                                </table>

                                                <div class="mt-3">
                                                    <button class="button btn-navigate-form-step" type="button"
                                                            step_number="2">Prev
                                                    </button>
                                                    <button class="button submit-btn" type="submit">Save</button>
                                                </div>
                                            </section>
                                        </form>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </main>
@stop

@section('js')
    <script>

        $(document).ready( function () {
            $('#myDataTable').DataTable();
        });

        function imageExtracting() {

            const form = document.getElementById("image-processing");
            const formData = new FormData(form);

            $.ajax({
                type: "post",
                headers: {'X-CSRF-TOKEN': $('meta[name="_token"]').val()},
                dataType: "json",
                url: '',
                processData: false,
                contentType: false,
                data: formData,
                success: function (response) {
                    console.log(response)
                }
            })

        }

        const navigateToFormStep = (stepNumber) => {

            if(stepNumber == 2){
                var name = document.getElementById("name").value;
                var email = document.getElementById("email").value;
                var number = document.getElementById("number").value;
                var address = document.getElementById("address").value;
                if (name == '' || email == '' || number == '' || address == '') {
                    alert('please fill all fields');
                    return false;
                }
            }
            // var image = document.getElementById("image-extract").value;
            // alert(image);

            if(stepNumber == 3){
                var fileInput = document.getElementById("image-extract");
                var selectedFile = fileInput.files;
                if (selectedFile == null) {
                    alert('please upload the image first');
                    return false;
                }
            }



            document.querySelectorAll(".form-step").forEach((formStepElement) => {
                formStepElement.classList.add("d-none");
            });
            /**
             * Mark all form steps as unfinished.
             */
            document.querySelectorAll(".form-stepper-list").forEach((formStepHeader) => {
                formStepHeader.classList.add("form-stepper-unfinished");
                formStepHeader.classList.remove("form-stepper-active", "form-stepper-completed");
            });
            /**
             * Show the current form step (as passed to the function).
             */
            document.querySelector("#step-" + stepNumber).classList.remove("d-none");
            /**
             * Select the form step circle (progress bar).
             */
            const formStepCircle = document.querySelector('li[step="' + stepNumber + '"]');
            /**
             * Mark the current form step as active.
             */
            formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-completed");
            formStepCircle.classList.add("form-stepper-active");
            /**
             * Loop through each form step circles.
             * This loop will continue up to the current step number.
             * Example: If the current step is 3,
             * then the loop will perform operations for step 1 and 2.
             */
            for (let index = 0; index < stepNumber; index++) {
                /**
                 * Select the form step circle (progress bar).
                 */
                const formStepCircle = document.querySelector('li[step="' + index + '"]');
                /**
                 * Check if the element exist. If yes, then proceed.
                 */
                if (formStepCircle) {
                    /**
                     * Mark the form step as completed.
                     */
                    formStepCircle.classList.remove("form-stepper-unfinished", "form-stepper-active");
                    formStepCircle.classList.add("form-stepper-completed");
                }
            }
        };
        /**
         * Select all form navigation buttons, and loop through them.
         */
        document.querySelectorAll(".btn-navigate-form-step").forEach((formNavigationBtn) => {
            /**
             * Add a click event listener to the button.
             */
            formNavigationBtn.addEventListener("click", () => {
                /**
                 * Get the value of the step.
                 */
                const stepNumber = parseInt(formNavigationBtn.getAttribute("step_number"));
                /**
                 * Call the function to navigate to the target form step.
                 */
                navigateToFormStep(stepNumber);
            });
        });
    </script>
@stop
