<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Writing Test - Academic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <link rel="stylesheet" media="all" href="https://use.fontawesome.com/releases/v6.1.0/css/all.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
</head>

<body>
    <div class="navbar-container fixed-top">
        <!-- First Fixed Nav-Bar -->
        <nav class="navbar navbar-expand-lg navbar-light custom-navbar">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="/assets/images/wingslogo_56x48.png" width="56" height="48" alt="Logo" />
                </a>
                <div class="navbar-text mx-auto">
                    <!-- Time counter here (You can use JavaScript to update this) -->
                    <span id="time-counter">01:00</span>
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
    <div class="container-fluid main-container">

        <div class="tab-content" id="pills-tabContent">
            @foreach ($organizedData as $row)
                @php
                    $partInfo = json_decode($row['part_info'], true);
                @endphp

                @if (!empty($partInfo))
                    @foreach ($partInfo as $part)
                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                            id="pills-part{{ $part['id'] + 1 }}" role="tabpanel"
                            aria-labelledby="pills-part{{ $part['id'] + 1 }}-tab" tabindex="0">
                            <div class="container-fluid-split">
                                <div class="container__left">
                                    <section class="test-contents ckeditor-wrapper"
                                        style="overflow-y: hidden; outline: none" tabindex="2">
                                        {!! $part['question_passage'] !!}
                                    </section>
                                </div>
                                <div class="resizer dragMe">
                                    <!-- <i class="fas fa-arrows-alt-h"></i> -->
                                </div>
                                <div class="container__right">
                                    <div class="container-fluid">
                                        <section class="test-panel writing-box"
                                            style="overflow-y: hidden; outline: none" tabindex="4">
                                            <div class="writing-box__answer-wrapper">
                                                <div
                                                    class="form-item js-form-item form-type-textarea js-form-type-textarea form-item-field-answer-task-{{ $part['id'] + 1 }} js-form-item-field-answer-task-{{ $part['id'] + 1 }} form-no-label form-group">
                                                    <div class="form-textarea-wrapper">
                                                        <textarea id="input{{ $part['id'] + 1 }}"
                                                            class="task-item__answer writing-box__answer form-control form-textarea resize-vertical"
                                                            data-drupal-selector="edit-field-answer-task-{{ $part['id'] + 1 }}" spellcheck="false"
                                                            placeholder="Type your essay here.." data-question-item="{{ $part['id'] + 1 }}"
                                                            name="field_answer_task_{{ $part['id'] + 1 }}" rows="5" cols="60"></textarea>
                                                    </div>
                                                </div>
                                                <div class="writing-box__footer">
                                                    <div class="writing-box__words-count">
                                                        Words Count:
                                                        <span
                                                            class="writing-box__words-num_{{ $part['id'] + 1 }}">0</span>
                                                    </div>
                                                </div>
                                            </div>
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
                <ul class="nav nav-pills mb-3 row justify-content-center" id="pills-tab" role="tablist">
                    @foreach ($organizedData as $row)
                        @php
                            $partInfo = json_decode($row['part_info'], true);
                        @endphp
                        @if (!empty($partInfo))
                            @foreach ($partInfo as $part)
                                <li class="nav-item col" role="presentation" style="padding: 0px 20px">
                                    <button
                                        class="nav-link {{ $loop->first ? 'active' : '' }} d-flex justify-content-center w-100"
                                        id="pills-part{{ $part['id'] + 1 }}-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-part{{ $part['id'] + 1 }}" type="button" role="tab"
                                        aria-controls="pills-part{{ $part['id'] + 1 }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        <div class="tab-name font-weight-bold text-center">{{ $part['short_title'] }}
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
{{-- <script>
    // Function to reload the page
    $(document).ready(function() {
        function reloadPage() {
            location.reload();
        }
        const onConfirmRefresh = function(event) {
            event.preventDefault();
            return event.returnValue = "Are you sure you want to leave the page?";
        }

        window.addEventListener("beforeunload", onConfirmRefresh, {
            capture: true
        });
    });
    $(document).ready(function() {
        var questionOptions = {
            questionSetId: 0, // Initialize questionSetId
            answers: {}, // Initialize answers object
        };

        @foreach ($organizedData as $row)
            @php
                $partInfo = json_decode($row['part_info'], true);
                $questionSetId = $row['question_set_id'];
            @endphp
            questionOptions.questionSetId = {{ $questionSetId }}; // Update questionSetId

            @if (!empty($partInfo))
                @foreach ($partInfo as $part)
                    // Add a unique identifier to the text area, e.g., 'textarea{{ $part['id'] + 1 }}'
                    var textareaId = 'input{{ $part['id'] + 1 }}';

                    console.log("Textarea ID:", textareaId);

                    // Capture the content of the text area
                    $(document).on('input', '#' + textareaId, function() {
                        var textAreaContent = $(this).val();
                        var partId = {{ $part['id'] }};

                        console.log("Textarea Content:", textAreaContent);

                        // Update the answers object
                        questionOptions.answers[partId] = {
                            text: textAreaContent,
                        };
                    });
                @endforeach
            @endif
        @endforeach

        $('.bt-submit').click(function() {
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            alert('You Want To Confirm');
            // Send the data to a route using AJAX
            $.ajax({
                url: "{{ route('submit_writting_answer') }}", // Replace 'your-submit-route' with the actual route name
                type: 'POST',
                data: {
                    questionSetId: questionOptions.questionSetId,
                    answers: questionOptions.answers,
                    _token: csrfToken,
                },
                dataType: 'json',

                success: function(response) {
                    // Handle the response from the server
                    window.location.href = "/test_score";
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    });
</script> --}}

<script>
    // Function to reload the page
    let isSubmitting = false;

    $(document).ready(function() {
        let questionOptions = {
            questionSetId: 0, // Initialize questionSetId
            answers: {}, // Initialize answers object
        };
        let examDuration = 40; // Default value, replace with dynamic value from PHP

        @foreach ($organizedData as $row)
            @php
                $partInfo = json_decode($row['part_info'], true);
                $questionSetId = $row['question_set_id'];
                $examDuration = $row['exam_duration']; // Get exam_duration from PHP variable
            @endphp
            questionOptions.questionSetId = {{ $questionSetId }}; // Update questionSetId
            examDuration = {{ $examDuration }}; // Assign PHP value to JavaScript variable

            @if (!empty($partInfo))
                @foreach ($partInfo as $part)
                    // Add a unique identifier to the text area, e.g., 'textarea{{ $part['id'] + 1 }}'
                    var textareaId = 'input{{ $part['id'] + 1 }}';

                    console.log("Textarea ID:", textareaId);

                    // Capture the content of the text area
                    $(document).on('input', '#' + textareaId, function() {
                        var textAreaContent = $(this).val();
                        var partId = {{ $part['id'] }};

                        console.log("Textarea Content:", textAreaContent);

                        // Update the answers object
                        questionOptions.answers[partId] = {
                            text: textAreaContent,
                        };
                    });
                @endforeach
            @endif
        @endforeach

        // ... Rest of your script for handling text area input

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
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            // alert('You Want To Confirm');
            // Send the data to a route using AJAX
            $.ajax({
                url: "{{ route('submit_writting_answer') }}", // Replace 'your-submit-route' with the actual route name
                type: 'POST',
                data: {
                    questionSetId: questionOptions.questionSetId,
                    answers: questionOptions.answers,
                    _token: csrfToken,
                },
                dataType: 'json',

                success: function(response) {
                    // Handle the response from the server
                    window.location.href = "/test_score";
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
</script>

<script src="{{ asset('assets/js/script.js') }}"></script>

</html>
