@extends('front.layouts.master')

    @section('head')
        @include('meta::manager', [
            'title' => ($settings_g['title'] ?? env('APP_NAME')) . ' - ' . ($settings_g['slogan'] ?? env('APP_NAME')),
        'description' => $settings_g['meta_description'] ?? '',
        'keywords' => $settings_g['keywords'] ?? '',
    ])
@endsection

@section('master')



    <div class="formbold-main-wrapper">
        <div class="formbold-form-wrapper">
            <form action="https://formbold.com/s/FORM_ID" method="POST">
                <div class="formbold-steps">
                    <ul>
                        <li class="formbold-step-menu1 active">
                            <span>1</span>
                            Type of Artwork
                        </li>
                        <li class="formbold-step-menu2">
                            <span>2</span>
                            Size
                        </li>
                        <li class="formbold-step-menu3">
                            <span>3</span>
                            Frame
                        </li>
                        <li class="formbold-step-menu4">
                            <span>4</span>
                            Text
                        </li>
                        <li class="formbold-step-menu5">
                            <span>5</span>
                            Illustration
                        </li>
                        <li class="formbold-step-menu6">
                            <span>6</span>
                            Preview Design
                        </li>
                    </ul>
                </div>

                <div class="formbold-form-step-1 active">
                    <div class="formbold-input-flex">
                        <div>
                            <label id="first_frame_title" for="firstname" class="formbold-form-label">Frame</label>
                            <select name="" id="first_frame" class="formbold-form-input" onchange="firstStepSelectChange(this.id)">
                                <option value="">select one</option>
                                <option value="1_1">Frame One</option>
                                <option value="1_2">Frame Two</option>
                                <option value="1_3">Frame Three</option>
                                <option value="1_4">Frame Four</option>
                            </select>
                        </div>
                        <div>
                            <label id="first_canvas_title" for="lastname" class="formbold-form-label">Canvas</label>
                            <select name="" id="first_canvas" class="formbold-form-input" onchange="firstStepSelectChange(this.id)">
                                <option value="">select one</option>
                                <option value="2_1">Canvas One</option>
                                <option value="2_2">Canvas Two</option>
                                <option value="2_3">Canvas Three</option>
                                <option value="2_4">Canvas Four</option>
                            </select>
                        </div>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label id="first_wooden_panel_title" for="lastname" class="formbold-form-label">Wooden Panel</label>
                            <select name="" id="first_wooden_panel" class="formbold-form-input" onchange="firstStepSelectChange(this.id)">
                                <option value="">select one</option>
                                <option value="3_1">Wooden Panel One</option>
                                <option value="3_2">Wooden Panel Two</option>
                                <option value="3_3">Wooden Panel Three</option>
                                <option value="3_4">Wooden Panel Four</option>
                            </select>
                        </div>
                        <div>
                            <label id="first_tree_wood_title" for="lastname" class="formbold-form-label">Tree wood</label>
                            <select name="" id="first_tree_wood" class="formbold-form-input" onchange="firstStepSelectChange(this.id)">
                                <option value="">select one</option>
                                <option value="4_1">Tree wood One</option>
                                <option value="4_2">Tree wood Two</option>
                                <option value="4_3">Tree wood Three</option>
                                <option value="4_4">Tree wood Four</option>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" id="step_one_value">
                </div>

                <div class="formbold-form-step-2">
                    <h2 id="stepTwoTitle" class="formbold-form-label" style="text-align: center; font-size: 24px;">Frame</h2>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="firstname" class="formbold-form-label">Type</label>
                            <select name="" id="step_two_type"  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">CM</option>
                                <option value="2">Inch</option>
                                <option value="3">MM</option>
                            </select>
                        </div>
                        <div>
                            <label for="" class="formbold-form-label">W: </label>
                            <input type="number" name="" placeholder="Width" id="step_two_w" class="formbold-form-input" />
                        </div>
                        <div>
                            <label for="" class="formbold-form-label">H: </label>
                            <input type="number" name="" placeholder="Height" id="step_two_h" class="formbold-form-input" />
                        </div>
                    </div>
                </div>

                <!-- <div class="formbold-form-step-3">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="firstname" class="formbold-form-label">Frame</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                        <div>
                            <label for="lastname" class="formbold-form-label">Without frame</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                    </div>
                </div> -->
                <div class="formbold-form-step-3">
                    <div class="formbold-input-flex">
                        <div>
                            <!-- Radio Button for Frame -->
                            <input type="radio" id="stepThreeFrameOption" name="stepThreeFrameSelection" value="frame" style="float: left;margin-top: 5px;margin-right: 5px;">
                            <label for="frameOption" class="formbold-form-label">Frame</label>

                            <!-- Radio Button for Without Frame -->
                            <input type="radio" id="stepThreeNoFrameOption" name="stepThreeFrameSelection" checked="checked" value="noFrame" style="float: left;margin-top: 5px;margin-right: 5px;">
                            <label for="noFrameOption" class="formbold-form-label">Without Frame</label>
                        </div>
                    </div>
                    <div id="stepThreeFrameSelect" class="hidden">
                        <label for="frameSelectField" class="formbold-form-label">Select Frame</label>
                        <select id="frameSelectField" class="formbold-form-input">
                            <option value="">Select one</option>
                            <option value="4_1">Frame One</option>
                            <option value="4_2">Frame Two</option>
                            <option value="4_3">Frame Three</option>
                            <option value="4_4">Frame Four</option>
                        </select>
                    </div>
                </div>

                <div class="formbold-form-step-4">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="firstname" class="formbold-form-label">Type text</label>
                            <input type="text" name="firstname" placeholder="Andrio" id="firstname" class="formbold-form-input" />
                        </div>
                        <div>
                            <label for="lastname" class="formbold-form-label">Text color</label>
                            <input type="text" name="firstname" placeholder="Andrio" id="firstname" class="formbold-form-input" />
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step-5">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="firstname" class="formbold-form-label">Type box</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                        <div>
                            <label for="lastname" class="formbold-form-label">Text color</label>
                            <input type="text" name="firstname" placeholder="Andrio" id="firstname" class="formbold-form-input" />
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step-6">
                    <div class="formbold-form-confirm">
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.
                        </p>
                    </div>
                </div>

                <div class="formbold-form-btn-wrapper">
                    <button class="formbold-back-btn">
                        Back
                    </button>

                    <button class="formbold-btn">
                        <span id="next_btn">Next Step</span>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1675_1807)">
                                <path
                                    d="M10.7814 7.33312L7.20541 3.75712L8.14808 2.81445L13.3334 7.99979L8.14808 13.1851L7.20541 12.2425L10.7814 8.66645H2.66675V7.33312H10.7814Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_1675_1807">
                                    <rect width="16" height="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
        <div class="formbold-form-preview">
            <h3 class="formbold-form-preview-heading">Preview</h3>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Inter", sans-serif;
        }

        .hidden {
            display: none;
        }

        .formbold-main-wrapper {
            display: flex;
            /* align-items: center; */
            justify-content: center;
            padding: 48px;
            width: 100%;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            width: 80%;
        }
        .formbold-form-preview {
            margin: 0 auto;
            width: 20%;
        }

        .formbold-steps{
            padding-bottom: 18px;
            margin-bottom: 35px;
            border-bottom: 1px solid #DDE3EC;
        }

        .formbold-steps ul {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            gap: 40px;
        }

        .formbold-steps li {
            display: flex;
            align-items: center;
            gap: 14px;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            color: #536387;
        }

        .formbold-form-preview-heading{
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            color: #07074D;
            text-align: center;
        }

        .formbold-steps li span {
            display: flex;
            align-items: center;
            justify-content: center;
            background: #DDE3EC;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            color: #536387;
        }

        .formbold-steps li.active {
            color: #07074D;
        }

        .formbold-steps li.active span {
            background: #6A64F1;
            color: #FFFFFF;
        }

        .formbold-input-flex {
            display: flex;
            gap: 20px;
            margin-bottom: 22px;
        }

        .formbold-input-flex>div {
            width: 50%;
        }

        .formbold-form-input {
            width: 100%;
            padding: 13px 22px;
            border-radius: 5px;
            border: 1px solid #DDE3EC;
            background: #FFFFFF;
            font-weight: 500;
            font-size: 16px;
            color: #536387;
            outline: none;
            resize: none;
        }

        .formbold-form-input:focus {
            border-color: #6a64f1;
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }

        .formbold-form-label {
            color: #07074D;
            font-weight: 500;
            font-size: 14px;
            line-height: 24px;
            display: block;
            margin-bottom: 10px;
        }

        .formbold-form-confirm {
            border-bottom: 1px solid #DDE3EC;
            padding-bottom: 35px;
        }

        .formbold-form-confirm p {
            font-size: 16px;
            line-height: 24px;
            color: #536387;
            margin-bottom: 22px;
            width: 75%;
        }

        .formbold-form-confirm>div {
            display: flex;
            gap: 15px;
        }

        .formbold-confirm-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FFFFFF;
            border: 0.5px solid #DDE3EC;
            border-radius: 5px;
            font-size: 16px;
            line-height: 24px;
            color: #536387;
            cursor: pointer;
            padding: 10px 20px;
            transition: all .3s ease-in-out;
        }

        .formbold-confirm-btn {
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.12);
        }

        .formbold-confirm-btn.active {
            background: #6A64F1;
            color: #FFFFFF;
        }

        .formbold-form-step-1,
        .formbold-form-step-2,
        .formbold-form-step-3,
        .formbold-form-step-4,
        .formbold-form-step-5,
        .formbold-form-step-6 {
            display: none;
        }

        .formbold-form-step-1.active,
        .formbold-form-step-2.active,
        .formbold-form-step-3.active,
        .formbold-form-step-4.active,
        .formbold-form-step-5.active,
        .formbold-form-step-6.active {
            display: block;
        }

        .formbold-form-btn-wrapper {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 25px;
            margin-top: 25px;
        }

        .formbold-back-btn {
            cursor: pointer;
            background: #FFFFFF;
            border: none;
            color: #07074D;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            display: none;
        }

        .formbold-back-btn.active {
            display: block;
        }

        .formbold-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 16px;
            border-radius: 5px;
            padding: 10px 25px;
            border: none;
            font-weight: 500;
            background-color: #6A64F1;
            color: white;
            cursor: pointer;
        }

        .formbold-btn:hover {
            box-shadow: 0px 3px 8px rgba(0, 0, 0, 0.05);
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script>
        const stepMenus = [
            document.querySelector('.formbold-step-menu1'),
            document.querySelector('.formbold-step-menu2'),
            document.querySelector('.formbold-step-menu3'),
            document.querySelector('.formbold-step-menu4'),
            document.querySelector('.formbold-step-menu5'),
            document.querySelector('.formbold-step-menu6')
        ];

        const steps = [
            document.querySelector('.formbold-form-step-1'),
            document.querySelector('.formbold-form-step-2'),
            document.querySelector('.formbold-form-step-3'),
            document.querySelector('.formbold-form-step-4'),
            document.querySelector('.formbold-form-step-5'),
            document.querySelector('.formbold-form-step-6')
        ];

        // Buttons
        const formSubmitBtn = document.querySelector('.formbold-btn');
        const nextBtn = document.querySelector('#next_btn');
        const formBackBtn = document.querySelector('.formbold-back-btn');

        // Current step tracker
        let currentStep = 0;

        // Helper function to update steps and menus
        function updateSteps(stepIndex) {
            steps.forEach((step, index) => {
                step.classList.toggle('active', index === stepIndex);
                stepMenus[index].classList.toggle('active', index === stepIndex);
            });

            // Update button states
            formBackBtn.classList.toggle('active', stepIndex > 0);
            nextBtn.textContent = stepIndex === steps.length - 1 ? 'Submit' : 'Next Step';
        }

        // Back button functionality
        formBackBtn.addEventListener("click", function(event) {
            event.preventDefault();
            if (currentStep > 0) {
                currentStep--;
                updateSteps(currentStep);
            }
        });

        // Next/Submit button functionality
        formSubmitBtn.addEventListener("click", function(event) {
            event.preventDefault();
            if (currentStep < steps.length - 1) {
                // step one
                if(currentStep == 0){
                    var step_one_data = $("#step_one_value").val();
                    if(step_one_data ==""){
                        alert("data need from step one");
                        return false;
                    }
                }
                // step two
                if(currentStep == 1){
                    var step_two_type = $("#step_two_type").val();
                    var step_two_w = $("#step_two_w").val();
                    var step_two_h = $("#step_two_h").val();
                    if(step_two_type == "" || step_two_w == "" || step_two_h == ""){
                        alert("data need from step two");
                        return false;
                    }
                }
                // step three
                if(currentStep == 2){
                    var stepThreeFrameSelection = $('input[name="stepThreeFrameSelection"]:checked').val();
                    var stepThreeFrameSelect = $("#stepThreeFrameSelect option:selected").val();
                    if(stepThreeFrameSelection == ""){
                        alert("data need from step three1");
                        return false;
                    }else if(stepThreeFrameSelection == "frame"){
                        if(stepThreeFrameSelect == ""){
                            alert("data need from step three1");
                            return false;
                        }
                    }
                }
                currentStep++;
                updateSteps(currentStep);
            } else {
                document.querySelector('form').submit();
            }
        });

        // Initialize the form
        updateSteps(currentStep);

        function firstStepSelectChange(id){
            if(id == "first_frame"){
                $("#first_canvas").val("");
                $("#first_wooden_panel").val("");
                $("#first_tree_wood").val("");
            }else if(id == "first_canvas"){
                $("#first_frame").val("");
                $("#first_wooden_panel").val("");
                $("#first_tree_wood").val("");
            }else if(id == "first_wooden_panel"){
                $("#first_canvas").val("");
                $("#first_frame").val("");
                $("#first_tree_wood").val("");
            }else if(id == "first_tree_wood"){
                $("#first_canvas").val("");
                $("#first_wooden_panel").val("");
                $("#first_frame").val("");
            }else{
                $("#first_canvas").val("");
                $("#first_wooden_panel").val("");
                $("#first_tree_wood").val("");
                $("#first_frame").val("");
            }
            var step_one_val = $("#"+id).val();
            $("#step_one_value").val($("#"+id).val());
            $("#stepTwoTitle").html($("#"+id+"_title").html());
        }
        $(document).ready(function() {
            // Event listener for radio buttons
            $('input[name="stepThreeFrameSelection"]').on('change', function () {
                console.log($(this).val());
                if ($(this).val() === 'frame') {
                    $('#stepThreeFrameSelect').removeClass('hidden'); // Show frame select field
                } else {
                    $('#stepThreeFrameSelect').addClass('hidden'); // Hide frame select field
                }
            });
        });

    </script>



@endsection
