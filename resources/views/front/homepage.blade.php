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
                            <label for="firstname" class="formbold-form-label">Frame</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                        <div>
                            <label for="lastname" class="formbold-form-label">Canvas</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="lastname" class="formbold-form-label">Wooden Panel</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                        <div>
                            <label for="lastname" class="formbold-form-label">Tree wood</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step-2">
                    <div class="formbold-input-flex">
                        <div>
                            <label for="firstname" class="formbold-form-label">Frame</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                        <div>
                            <label for="lastname" class="formbold-form-label">Wooden Panel</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                    </div>
                    <div class="formbold-input-flex">
                        <div>
                            <label for="lastname" class="formbold-form-label">Tree wood</label>
                            <select name="" id=""  class="formbold-form-input">
                                <option value="">select one</option>
                                <option value="1">One</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="formbold-form-step-3">
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

                        <div>
                            <button class="formbold-confirm-btn active">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="10.5" fill="white" stroke="#DDE3EC" />
                                    <g clip-path="url(#clip0_1667_1314)">
                                        <path
                                            d="M9.83343 12.8509L15.1954 7.48828L16.0208 8.31311L9.83343 14.5005L6.12109 10.7882L6.94593 9.96336L9.83343 12.8509Z"
                                            fill="#536387" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1667_1314">
                                            <rect width="14" height="14" fill="white" transform="translate(4 4)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                Yes! I want it.
                            </button>

                            <button class="formbold-confirm-btn">
                                <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11" cy="11" r="10.5" fill="white" stroke="#DDE3EC" />
                                    <g clip-path="url(#clip0_1667_1314)">
                                        <path
                                            d="M9.83343 12.8509L15.1954 7.48828L16.0208 8.31311L9.83343 14.5005L6.12109 10.7882L6.94593 9.96336L9.83343 12.8509Z"
                                            fill="#536387" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_1667_1314">
                                            <rect width="14" height="14" fill="white" transform="translate(4 4)" />
                                        </clipPath>
                                    </defs>
                                </svg>
                                No! I don’t want it.
                            </button>
                        </div>
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

        .formbold-main-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
        }

        .formbold-form-wrapper {
            margin: 0 auto;
            /* max-width: 550px; */
            width: 100%;
            background: white;
        }

        .formbold-steps {
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
            ;
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
    <script>
        const stepMenuOne = document.querySelector('.formbold-step-menu1')
        const stepMenuTwo = document.querySelector('.formbold-step-menu2')
        const stepMenuThree = document.querySelector('.formbold-step-menu3')
        const stepMenuFour = document.querySelector('.formbold-step-menu4')
        const stepMenuFive = document.querySelector('.formbold-step-menu5')
        const stepMenuSix = document.querySelector('.formbold-step-menu6')

        const stepOne = document.querySelector('.formbold-form-step-1')
        const stepTwo = document.querySelector('.formbold-form-step-2')
        const stepThree = document.querySelector('.formbold-form-step-3')
        const stepFour = document.querySelector('.formbold-form-step-4')
        const stepFive = document.querySelector('.formbold-form-step-5')
        const stepSix = document.querySelector('.formbold-form-step-6')

        const formSubmitBtn = document.querySelector('.formbold-btn')
        const next_btn = document.querySelector('#next_btn')
        const formBackBtn = document.querySelector('.formbold-back-btn')

        formBackBtn.addEventListener("click", function(event) {
            event.preventDefault();
            if (stepMenuTwo.className == 'formbold-step-menu2 active') {
                stepMenuOne.classList.add('active')
                stepMenuTwo.classList.remove('active')
                stepOne.classList.add('active')
                stepTwo.classList.remove('active')
                formBackBtn.classList.remove('active')
            } else if (stepMenuThree.className == 'formbold-step-menu3 active') {
                stepMenuTwo.classList.add('active')
                stepMenuThree.classList.remove('active')
                stepTwo.classList.add('active')
                stepThree.classList.remove('active')
            } else if (stepMenuFour.className == 'formbold-step-menu4 active') {
                stepMenuThree.classList.add('active')
                stepMenuFour.classList.remove('active')
                stepThree.classList.add('active')
                stepFour.classList.remove('active')
            } else if (stepMenuFive.className == 'formbold-step-menu5 active') {
                stepMenuFour.classList.add('active')
                stepMenuFive.classList.remove('active')
                stepFour.classList.add('active')
                stepFive.classList.remove('active')
            } else if (stepMenuSix.className == 'formbold-step-menu6 active') {
                stepMenuFive.classList.add('active')
                stepMenuSix.classList.remove('active')
                stepFive.classList.add('active')
                stepSix.classList.remove('active')
                next_btn.textContent = 'Next Step'
            }
        })


        formSubmitBtn.addEventListener("click", function(event) {
            event.preventDefault()
            if (stepMenuOne.className == 'formbold-step-menu1 active') {
                event.preventDefault()
                stepMenuOne.classList.remove('active')
                stepMenuTwo.classList.add('active')
                stepOne.classList.remove('active')
                stepTwo.classList.add('active')
                formBackBtn.classList.add('active')
            } else if (stepMenuTwo.className == 'formbold-step-menu2 active') {
                event.preventDefault()
                stepMenuTwo.classList.remove('active')
                stepMenuThree.classList.add('active')
                stepTwo.classList.remove('active')
                stepThree.classList.add('active')
            }else if (stepMenuThree.className == 'formbold-step-menu3 active') {
                event.preventDefault()
                stepMenuThree.classList.remove('active')
                stepMenuFour.classList.add('active')
                stepThree.classList.remove('active')
                stepFour.classList.add('active')
            }else if (stepMenuFour.className == 'formbold-step-menu4 active') {
                event.preventDefault()
                stepMenuFour.classList.remove('active')
                stepMenuFive.classList.add('active')
                stepFour.classList.remove('active')
                stepFive.classList.add('active')
            }else if (stepMenuFive.className == 'formbold-step-menu5 active') {
                event.preventDefault()
                stepMenuFive.classList.remove('active')
                stepMenuSix.classList.add('active')
                stepFive.classList.remove('active')
                stepSix.classList.add('active')
                next_btn.textContent = 'Submit'
            } else if (stepMenuSix.className == 'formbold-step-menu6 active') {
                document.querySelector('form').submit()
            }
        })
    </script>
@endsection
