<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Reading Test - Academic</title>
    <link rel="stylesheet" media="all" href="https://use.fontawesome.com/releases/v6.1.0/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

</head>

<body>
    <div class="navbar-container fixed-top">
        <!-- First Fixed Nav-Bar -->
        <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/img/wingslogo.png') }}" width="56" height="48" alt="Logo" />
                </a>
                <div class="navbar-text mx-auto">
                    <!-- Time counter here (You can use JavaScript to update this) -->
                    <span id="time-counter">40:00</span>
                </div>
                <div class="navbar-text">

                    <div class="">

                    </div>
                    <button type="button" class="btn btn-danger bt-submit" data-bs-toggle="modal"
                        data-bs-target="#submit_modal">
                        Submit <i class="fa-solid fa-angles-right fa-lg"></i>
                    </button>



                </div>
            </div>
            <div class="">
                <button class="js-toggle-fullscreen-btn toggle-fullscreen-btn" aria-label="Enter fullscreen mode"
                    hidden>
                    <svg class="toggle-fullscreen-svg" width="28" height="28" viewBox="-2 -2 28 28">
                        <g class="icon-fullscreen-enter">
                            <path d="M 2 9 v -7 h 7" />
                            <path d="M 22 9 v -7 h -7" />
                            <path d="M 22 15 v 7 h -7" />
                            <path d="M 2 15 v 7 h 7" />
                        </g>

                        <g class="icon-fullscreen-leave">
                            <path d="M 24 17 h -7 v 7" />
                            <path d="M 0 17 h 7 v 7" />
                            <path d="M 0 7 h 7 v -7" />
                            <path d="M 24 7 h -7 v -7" />
                        </g>
                    </svg>
                </button>
            </div>
        </nav>


    </div>
    <div class="container-fluid main-container position-relative">
        <div class="position-fixed" id="count_answer"
            style="
        top: 80px;
        right: 50px;
        border-radius: 10px;
        border: 1px solid green;
        padding: 10px 15px;
        font-size: 20px; ">

        </div>
        <div class="tab-content" id="pills-tabContent">

            @foreach ($organizedData as $row)
                @php
                    $partInfo = json_decode($row['part_info'], true);
                @endphp

                @if (!empty($partInfo))
                    @foreach ($partInfo as $part)
                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                            id="pills-part{{ $part['id'] }}" role="tabpanel"
                            aria-labelledby="pills-part{{ $part['id'] }}-tab" tabindex="0">
                            <div class="container-fluid-split">
                                <div class="container__left passage" id="passage">
                                    {!! $part['question_passage'] !!}
                                </div>

                                <div class="resizer dragMe">
                                    <!-- <i class="fas fa-arrows-alt-h"></i> -->
                                </div>

                                <div class="container__right">
                                    <div class="container-fluid">
                                        <section class="test-panel" style="overflow-y: hidden; outline: none"
                                            tabindex="2">
                                            <div class="test-panel__header">
                                                <h2 class="test-panel__title">{{ $part['short_title'] }}</h2>
                                                <div class="test-panel__title-caption"></div>
                                            </div>
                                            <div class="test-panel__item">
                                                <!-- Rest of your content for Part 1 -->
                                                <section class="test-panel" style="overflow-y: hidden; outline: none"
                                                    tabindex="2">

                                                    @foreach ($organizedData as $row)
                                                        @php
                                                            $questioninfo = $row['questions'];
                                                        @endphp

                                                        @if (!empty($questioninfo))
                                                            @php
                                                                $q_count = 0;
                                                            @endphp
                                                            @foreach ($questioninfo as $questionId => $question)
                                                                @if ($q_count + 1 >= $part['start'] && $q_count + 1 <= $part['end'])
                                                                    <div class="test-panel__item"
                                                                        id=@php
$c_input = substr_count($question['title'], '<input');
                                                                            $c_dropdown = substr_count($question['title'], '<select');

                                                                            if ($c_input + $c_input == 1) {
                                                                             $temp_q = $q_count + 1;
                                                                             echo 'ques-' . $temp_q;
                                                                             }
                                                                             elseif ($c_dropdown + $c_dropdown == 1) {
                                                                             $temp_q = $q_count + 1;
                                                                             echo 'ques-' . $temp_q;
                                                                            }
                                                                            else {
                                                                            $temp_q = $q_count + 1;
                                                                            echo 'ques-' . $temp_q;
                                                                            } @endphp>
                                                                        <div class="test-panel__question">
                                                                            <!-- <p>Part ID: {{ $part['id'] }}, Question ID: {{ $questionId }}, Q Count: {{ $q_count + 1 }}, part start : {{ $part['start'] }} , part end : {{ $part['end'] }} ,</p> -->
                                                                            <h4 class="test-panel__question-title">
                                                                                Question
                                                                                @php
                                                                                    $c_input = substr_count($question['title'], '<input');
                                                                                    $c_dropdown = substr_count($question['title'], '<select');
                                                                                    $total_c = $c_input + $c_dropdown;
                                                                                    if ($total_c == 0 || $total_c == 1) {
                                                                                        $q_count += 1;
                                                                                        echo $q_count;
                                                                                        $temporary_count = $q_count;
                                                                                    } else {
                                                                                        $q_count += 1;
                                                                                        echo $q_count;
                                                                                        $temporary_count = $q_count;
                                                                                        $q_count += $total_c - 1;
                                                                                        echo '-' . $q_count;
                                                                                } @endphp </h4>


                                                                            <div class="test-panel__question-desc">
                                                                                <div
                                                                                    class="field field--name-field-question field--type-text-long field--label-hidden field--item">
                                                                                    <p>


                                                                                    <p>
                                                                                        @php
                                                                                            $start = $temporary_count; // Set your initial start value
                                                                                            // Use a single regular expression for both <input> and <select>
                                                                                            $modifiedTitle = preg_replace_callback(
                                                                                                '/<(input|select) /',
                                                                                                function ($matches) use (&$start) {
                                                                                                    $tag = $matches[1];
                                                                                                    $replacement = '<' . $tag . ' id="ques-' . $start . '" placeholder="' . $start++ . '"';
                                                                                                    return $replacement;
                                                                                                },
                                                                                                $question['title'],
                                                                                            );
                                                                                        @endphp
                                                                                        {!! $modifiedTitle !!}
                                                                                    </p>
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        @if (isset($question['type']))
                                                                            @php
                                                                                // Sort options by their IDs in ascending order
                                                                                $sortedOptions = collect($question['options'])
                                                                                    ->sortBy('option_id')
                                                                                    ->values()
                                                                                    ->all();
                                                                            @endphp
                                                                            @if ($question['type'] == 1)
                                                                                <div class="test-panel__answer">
                                                                                    @foreach ($sortedOptions as $optionKey => $option)
                                                                                        <div
                                                                                            class="test-panel__answer-item">
                                                                                            <span
                                                                                                class="test-panel__answer-option"
                                                                                                style="font-weight: bold"></span>
                                                                                            {{-- ({{ chr(65 + $optionKey) }}) --}}
                                                                                            <label class="iot-radio"
                                                                                                for="q-{{ $questionId }}-{{ $optionKey }}">
                                                                                                <input type="radio"
                                                                                                    class="radio-iot iot-lr-question"
                                                                                                    id="q-{{ $questionId }}-{{ $optionKey }}"
                                                                                                    data-num="{{ $questionId }}"
                                                                                                    name="q-{{ $questionId }}"
                                                                                                    data-q_type="15"
                                                                                                    value="{{ $option['option'] }}" />
                                                                                                <span
                                                                                                    class="checkmark"></span>
                                                                                                <span
                                                                                                    class="cb-label">{{ $option['option'] }}</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @elseif ($question['type'] == 2)
                                                                                <div
                                                                                    class="test-panel__answer checkbox-group">
                                                                                    @foreach ($sortedOptions as $optionKey => $option)
                                                                                        <div
                                                                                            class="test-panel__answer-item">
                                                                                            <span
                                                                                                class="test-panel__answer-option"
                                                                                                style="font-weight: bold"></span>
                                                                                            {{-- ({{ chr(65 + $optionKey) }}) --}}
                                                                                            <label class="iot-radio"
                                                                                                for="q-{{ $questionId }}-{{ $optionKey }}">
                                                                                                <input type="checkbox"
                                                                                                    class="radio-iot iot-lr-question"
                                                                                                    id="q-{{ $questionId }}-{{ $optionKey }}"
                                                                                                    data-num="{{ $questionId }}"
                                                                                                    name="q-{{ $questionId }}"
                                                                                                    data-q_type="15"
                                                                                                    value="{{ $option['option'] }}" />
                                                                                                <span
                                                                                                    class="checkmark"></span>
                                                                                                <span
                                                                                                    class="cb-label">{{ $option['option'] }}</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @elseif ($question['type'] == 4)
                                                                                <div class="test-panel__answer">
                                                                                    @foreach ($question['options'] as $optionKey => $option)
                                                                                        <div
                                                                                            class="test-panel__answer-item">
                                                                                            <span
                                                                                                class="test-panel__answer-option"
                                                                                                style="font-weight: bold"></span>
                                                                                            <label class="iot-radio"
                                                                                                style="display: flex;"
                                                                                                for="q-{{ $questionId }}-{{ $optionKey }}">
                                                                                                <input type="radio"
                                                                                                    class="radio-iot iot-lr-question"
                                                                                                    id="q-{{ $questionId }}-{{ $optionKey }}"
                                                                                                    data-num="{{ $questionId }}"
                                                                                                    name="q-{{ $questionId }}"
                                                                                                    data-q_type="15"
                                                                                                    value="{{ $option['option'] }}" />
                                                                                                <span
                                                                                                    class="checkmark"></span>
                                                                                                <span class="cb-label"
                                                                                                    style="margin-left: 15px;">{!! $option['option'] !!}</span>
                                                                                            </label>
                                                                                        </div>
                                                                                    @endforeach
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                @else
                                                                    @php
                                                                        $c_input = substr_count($question['title'], '<input');
                                                                        $c_dropdown = substr_count($question['title'], '<select');
                                                                        $total_c = $c_input + $c_dropdown;
                                                                        if ($total_c == 0 || $total_c == 1) {
                                                                            $q_count += 1;
                                                                        } else {
                                                                            $q_count += 1;
                                                                            $q_count += $total_c - 1;
                                                                    } @endphp
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    @endforeach
                                                </section>
                                            </div>
                                    </div>
                                </div>

                                <div class="take-test__bottom-palette">
                                    <div class="container-fluid">
                                        <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab"
                                            role="tablist">
                                            @foreach ($organizedData as $row)
                                                @php
                                                    $partInfo = json_decode($row['part_info'], true);
                                                @endphp
                                                @if (!empty($partInfo))
                                                    @foreach ($partInfo as $part)
                                                        <li class="nav-item" role="presentation">
                                                            <button
                                                                class="nav-link {{ $loop->first ? 'active' : '' }} d-flex"
                                                                id="pills-part{{ $part['id'] }}-tab"
                                                                data-bs-toggle="pill"
                                                                data-bs-target="#pills-part{{ $part['id'] }}"
                                                                type="button" role="tab"
                                                                aria-controls="pills-part{{ $part['id'] }}"
                                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                                <div class="tab-name font-weight-bold me-1">
                                                                    {{ $part['short_title'] }}:
                                                                </div>
                                                                <div class="tab-number">{{ $part['title'] }}</div>
                                                                <div class="tab-number-count">
                                                                    @for ($i = $part['start']; $i <= $part['end']; $i++)
                                                                        <span
                                                                            onclick="scrollToQues2('ques-{{ $i }}', event)">
                                                                            <p>{{ $i }}</p>
                                                                        </span>
                                                                    @endfor
                                                                </div>
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                @endif
                                            @endforeach
                                        </ul>

                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    No part info available.
                @endif
            @endforeach

        </div>


        <div class="take-test__bottom-palette">
            <div class="container-fluid">
                <ul class="nav nav-pills mb-3 d-flex justify-content-center" id="pills-tab" role="tablist">
                    @foreach ($organizedData as $row)
                        @php
                            $partInfo = json_decode($row['part_info'], true);
                        @endphp
                        @if (!empty($partInfo))
                            @foreach ($partInfo as $part)
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }} d-flex"
                                        id="pills-part{{ $part['id'] }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-part{{ $part['id'] }}" type="button"
                                        role="tab" aria-controls="pills-part{{ $part['id'] }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        <div class="tab-name font-weight-bold me-1">
                                            {{ $part['short_title'] }}:
                                        </div>
                                        <div class="tab-number">{{ $part['title'] }}</div>
                                        <div class="tab-number-count">
                                            @for ($i = $part['start']; $i <= $part['end']; $i++)
                                                <span onclick="scrollToQues2('ques-{{ $i }}', event)">
                                                    <p>{{ $i }}</p>
                                                </span>
                                            @endfor
                                        </div>
                                    </button>
                                </li>
                            @endforeach
                        @endif
                    @endforeach
                </ul>
            </div>
        </div>
    </div>


</body>

<div class="modal fade text-center" tabindex="-1" role="dialog" id="popupModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h5 class="modal-title text-center">Time is up!</h5>
                <!-- <button
              type="button"
              class="btn-close"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button> -->
            </div>
            <div class="modal-body">
                <p id="modalMessage"></p>
                {{-- <p class="modal-des">
                    However, we realize that you have not completed the test yet.
                    <br />
                    Please click the "Retake" button below to take the test again before
                    submitting.
                </p>
                <div class="modal-body">

                    <button class="iot-bt btn btn-danger" href="#" onclick="reloadPage()">
                        Retake
                    </button>
                </div> --}}
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="submit_modal" tabindex="-1" role="dialog" aria-labelledby="submit_modalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header justify-content-center">
                <h4 class="text-center">Test Ended</h4>
                {{-- <h5 class="modal-title" id="submit_modalTitle"></h5> --}}
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button> --}}
            </div>
            <div class="modal-body">
                <p class="text-center">Your test has finished. <br>

                    All of your answers have been stored.<br>

                    Please wait for further instructions.</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                <button type="button" class="btn btn-danger bt-submit-form">Continue</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>

<script>
    // Function to reload the page

    let isSubmitting = false;

    $(document).ready(function() {
        let questionOptions = {};
        let questionSetId;
        let examDuration = 40; // Default value

        @foreach ($organizedData as $row)
            @php
                $questionSetId = $row['question_set_id'];
                $questioninfo = $row['questions'];
                $examDuration = $row['exam_duration']; // Get exam_duration from PHP variable
            @endphp
            questionSetId = {{ $questionSetId }};
            examDuration = {{ $examDuration }}; // Assign PHP value to JavaScript variable
            @if (!empty($questioninfo))
                @foreach ($questioninfo as $questionId => $question)
                    questionOptions[{{ $questionId }}] = [
                        @foreach ($question['options'] as $optionKey => $option)
                            {
                                question_id: {{ $questionId }},
                                index: {{ $optionKey }},
                                text: "{{ $option['option'] }}"
                            },
                        @endforeach
                    ];
                @endforeach
            @endif
        @endforeach

        let countdown;
        // const countdownDuration = 1 * 60; // 1 minute (for testing)
        // const countdownDuration = 40 * 60;
        const countdownDuration = examDuration * 60; // Use examDuration here

        function updateCountdown() {
            const minutes = Math.floor(countdown / 60);
            const seconds = countdown % 60;
            const countdownDisplay = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;
            document.getElementById("time-counter").textContent = countdownDisplay;

            if (countdown === 0) {
                clearInterval(interval);
                showPopUpAndSubmit();
            }
            countdown--;
        }

        function showPopUpAndSubmit() {
            isSubmitting = true; // Set the flag to prevent the confirmation message
            const popUpMessage = "Time's up! Your answers will be submitted automatically.";

            // Show Bootstrap modal with the message
            const modal = new bootstrap.Modal(document.getElementById("popupModal"));
            const modalMessage = document.getElementById("modalMessage");
            modalMessage.textContent = popUpMessage;
            modal.show();

            // Automatically submit the form after a delay (adjust the delay as needed)
            setTimeout(submitForm, 1000); // 5 seconds delay before submission
        }

        function submitForm() {
            let selectedOptions = {};
            let mydata = "";

            // Loop through checkbox inputs
            $('input[type="checkbox"]').each(function() {
                let questionId = $(this).data('num');
                let optionIndex = $(this).val();

                if ($(this).is(':checked')) {
                    // If the question ID is not in selectedOptions, initialize it as an empty string
                    selectedOptions[questionId] = selectedOptions[questionId] || '';

                    // Append the optionIndex to the existing string with a comma (if not the first option)
                    if (selectedOptions[questionId] !== '') {
                        selectedOptions[questionId] += '#';
                    }

                    selectedOptions[questionId] += optionIndex;
                }
            });

            // Loop through radio inputs
            $('input[type="radio"]:checked').each(function() {
                let questionId = $(this).data('num');
                let optionIndex = $(this).val();

                // Check if this question has already been processed for radio questions
                if (!selectedOptions.hasOwnProperty(questionId)) {
                    mydata += "Question " + questionId + ": " + optionIndex + "\n";
                    // Mark the question as processed
                    selectedOptions[questionId] = true;
                }
            });

            // Loop through text inputs
            $('input[type="text"]').each(function() {
                let questionId = $(this).data('num');
                let optionIndex = $(this).val();

                // Check if this question has already been processed for text inputs
                if (!selectedOptions.hasOwnProperty(questionId)) {
                    mydata += "Question " + questionId + ": " + optionIndex + "\n";
                    // Mark the question as processed
                    selectedOptions[questionId] = true;
                }
            });

            $('select').each(function() {
                let questionId = $(this).data('num');
                let optionIndex = $(this).val();

                // Check if this question has already been processed for select inputs
                if (!selectedOptions.hasOwnProperty(questionId)) {
                    mydata += "Question " + questionId + ": " + optionIndex + "\n";
                    // Mark the question as processed
                    selectedOptions[questionId] = true;
                }
            });

            // Loop through checkbox questions again and print the concatenated options
            for (let questionId in selectedOptions) {
                if (typeof selectedOptions[questionId] === 'string') {
                    mydata += "Question " + questionId + ": " + selectedOptions[questionId] + "\n";
                }
            }

            // console.log(mydata);
            console.log(mydata);

            // let selectedOptionsData = [];
            // for (let questionId in selectedOptions) {
            //     let optionIndex = selectedOptions[questionId];
            //     let optionData = questionOptions[questionId] ? questionOptions[questionId][optionIndex] : null;

            //     if (optionData) {
            //         selectedOptionsData.push(optionData);
            //     }
            // }

            // let selectedOptionsString = selectedOptionsData.map(function(option) {
            //     return `Question ${option.question_id}: ${option.text}`;
            // }).join('\n');

            // let data = selectedOptionsString;
            let csrfToken = $('meta[name="csrf-token"]').attr('content');

            // console.log(data);

            $.ajax({
                url: "{{ route('store-reading-test-score') }}",
                type: 'POST',
                data: {
                    selectedOptions: mydata,
                    questionSetId: questionSetId,
                    _token: csrfToken,
                },
                success: function(response) {
                    window.location.href = "/academic/writing/confirm_details";
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        }

        $('.bt-submit-form').click(function() {
            submitForm();
        });



        // Start the countdown automatically
        countdown = countdownDuration;
        updateCountdown();
        const interval = setInterval(updateCountdown, 1000);
    });


    // count all answer

    function countSelectedRadios() {
        const radioGroups = document.querySelectorAll('input[type="radio"]:checked');
        return radioGroups.length;
    }

    // function countSelectedCheckbox(){
    //     const checkboxGroups = document.querySelectorAll('input[type="checkbox"]:checked');
    //     return checkboxGroups.length;
    // }
    function countSelectedCheckbox() {
        const checkboxDivs = document.querySelectorAll('.checkbox-group');
        let totalCount = 0;

        checkboxDivs.forEach((div) => {
            const checkboxes = div.querySelectorAll('input[type="checkbox"]');
            const isChecked = Array.from(checkboxes).some((checkbox) => checkbox.checked);

            if (isChecked) {
                totalCount++;
            }
        });

        return totalCount;
    }

    function countFilledTextInputs() {
        const textInputElements = document.querySelectorAll('input[type="text"]');
        let count = 0;

        textInputElements.forEach(input => {
            if (input.value.trim() !== '') {
                count++;
            }
        });

        return count;
    }

    function countFilledTextDropdown() {
        const textDropdownElements = document.querySelectorAll('select');
        let count = 0;

        textDropdownElements.forEach(input => {
            if (input.value.trim() !== '') {
                count++;
            }
        });

        return count;
    }

    function updateCount() {
        const selectedRadiosCount = countSelectedRadios();
        const filledTextInputCount = countFilledTextInputs();
        const filledTextDropdownCount = countFilledTextDropdown();
        const filledCheckboxCount = countSelectedCheckbox();
        let total_ans = selectedRadiosCount + filledTextInputCount + filledCheckboxCount + filledTextDropdownCount;

        document.getElementById('count_answer').innerHTML = total_ans + "/40";
    }

    // Attach the updateCount function to relevant events (e.g., change, input, etc.)
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        radio.addEventListener('change', updateCount);
    });

    document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
        checkbox.addEventListener('change', updateCount);
    });

    document.querySelectorAll('input[type="text"]').forEach(input => {
        input.addEventListener('input', updateCount);
    });
    document.querySelectorAll('select').forEach(input => {
        input.addEventListener('change', updateCount);
    });


    // Initial count on page load
    updateCount();
</script>

<link rel="stylesheet" href="{{ asset('js/annotator.min.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script src="{{ asset('js/annotator-full.min.js') }}"></script>

{{-- highlight and note --}}
<script>
    $(document).ready(function() {
        // Initialize Annotator on the news container
        var annotator = $('body').annotator({
            // Add separate toolbar buttons for highlighting and commenting
            toolbar: {
                highlight: {
                    icon: 'fa fa-pencil',
                    title: 'Highlight',
                    label: true
                },
                comment: {
                    icon: 'fa fa-comment',
                    title: 'Comment',
                    label: true
                }
            },
            // Only allow highlighting and commenting, disable other annotation types
            annotationTypes: {
                'highlight': {},
                'comment': {}
            }
        });

        $('.test-panel__question-title').click(function() {
            var questionId = $(this).data('num');
            $('#question-' + questionId + ' .test-panel__answer').toggle();
        });
    });
</script>


</html>
