document.addEventListener("DOMContentLoaded", function () {
    // Get the elements by class name
    const resizers = document.getElementsByClassName("dragMe");
    if (resizers.length > 0) {
        for (let i = 0; i < resizers.length; i++) {
            const resizer = resizers[i];
            const leftSide = resizer.previousElementSibling;
            const rightSide = resizer.nextElementSibling;
            let x = 0;
            let leftWidth = 0;

            const mouseDownHandler = function (e) {
                x = e.clientX;
                leftWidth = leftSide.getBoundingClientRect().width;
                document.addEventListener("mousemove", mouseMoveHandler);
                document.addEventListener("mouseup", mouseUpHandler);
            };

            const mouseMoveHandler = function (e) {
                const dx = e.clientX - x;
                const newLeftWidth =
                    ((leftWidth + dx) * 100) /
                    resizer.parentNode.getBoundingClientRect().width;
                leftSide.style.width = newLeftWidth + "%";
            };

            const mouseUpHandler = function () {
                document.removeEventListener("mousemove", mouseMoveHandler);
                document.removeEventListener("mouseup", mouseUpHandler);
            };

            resizer.addEventListener("mousedown", mouseDownHandler);
        }
    }
});

// document.addEventListener("DOMContentLoaded", function () {
//     let countdown;
//     const countdownDuration = 40 * 60; // 40 minutes

//     function updateCountdown() {
//         const minutes = Math.floor(countdown / 60);
//         const seconds = countdown % 60;
//         const countdownDisplay = `${minutes}:${
//             seconds < 10 ? "0" : ""
//         }${seconds}`;
//         document.getElementById("time-counter").textContent = countdownDisplay;

//         if (countdown === 0) {
//             clearInterval(interval);
//             showPopUp();
//         }
//         countdown--;
//     }

//     function showPopUp() {
//         const popUpMessage = "Time's up!";

//         // Show Bootstrap modal with the message
//         const modal = new bootstrap.Modal(
//             document.getElementById("popupModal")
//         );
//         const modalMessage = document.getElementById("modalMessage");
//         modalMessage.textContent = popUpMessage;
//         modal.show();
//     }

//     // Start the countdown automatically
//     countdown = countdownDuration;
//     updateCountdown();
//     const interval = setInterval(() => {
//         updateCountdown();
//         if (countdown === 0) {
//             clearInterval(interval);
//             showPopUp();
//         }
//     }, 1000);
// });

document.addEventListener("DOMContentLoaded", function () {});

document.addEventListener("DOMContentLoaded", function () {
    if (document.fullscreenEnabled || document.webkitFullscreenEnabled) {
        const toggleBtn = document.querySelector(".js-toggle-fullscreen-btn");

        const styleEl = document.createElement("link");
        styleEl.setAttribute("rel", "stylesheet");
        styleEl.setAttribute(
            "href",
            "https://codepen.io/tiggr/pen/poJoLyW.css"
        );
        styleEl.addEventListener("load", function () {
            toggleBtn.hidden = false;
        });
        document.head.appendChild(styleEl);

        toggleBtn.addEventListener("click", function () {
            if (document.fullscreen) {
                document.exitFullscreen();
            } else if (document.webkitFullscreenElement) {
                document.webkitCancelFullScreen();
            } else if (document.documentElement.requestFullscreen) {
                document.documentElement.requestFullscreen();
            } else {
                document.documentElement.webkitRequestFullScreen();
            }
        });

        document.addEventListener("fullscreenchange", handleFullscreen);
        document.addEventListener("webkitfullscreenchange", handleFullscreen);

        function handleFullscreen() {
            if (document.fullscreen || document.webkitFullscreenElement) {
                toggleBtn.classList.add("on");
                toggleBtn.setAttribute("aria-label", "Exit fullscreen mode");
            } else {
                toggleBtn.classList.remove("on");
                toggleBtn.setAttribute("aria-label", "Enter fullscreen mode");
            }
        }
    }
});

document.addEventListener("DOMContentLoaded", function () {});

function scrollToQues(ques_id, e) {
    console.log(ques_id);
    // let current_ques = ques_id;
    let ques = document.getElementById(ques_id);
    e.preventDefault(); // Prevent the default jump-to-anchor behavior

    if (ques) {
        console.log(ques_id);
        window.scroll({
            behavior: "smooth", // Use smooth scrolling
            left: 0, // Keep the scroll position at the left (horizontal)
            top: ques.offsetTop - 150, // Scroll to 100px above the top of the element
        });
        if (ques.tagName.toLowerCase() === "input") {
            ques.focus();
        }
    }
}

// function scrollToQues2(ques_id, e) {
//   console.log(ques_id);
//   // let current_ques = ques_id;
//   let ques = document.getElementById(ques_id);
//   e.preventDefault(); // Prevent the default jump-to-anchor behavior

//   if (ques) {
//     console.log(ques_id);
//     let container = document.querySelector(".container__right");
//     container.scroll({
//       behavior: "smooth", // Use smooth scrolling
//       top: ques.offsetTop - container.offsetTop - 15, // Scroll to 100px above the top of the element
//     });
//   }
// }

// function scrollToQues2(ques_id, e) {
//     e.preventDefault(); // Prevent the default jump-to-anchor behavior

//     let ques = document.getElementById(ques_id);

//     if (ques) {
//         let containers = document.querySelectorAll(".container__right");

//         containers.forEach(function (container) {
//             container.scroll({
//                 behavior: "smooth",
//                 top: ques.offsetTop - container.offsetTop - 20,
//             });
//         });

//         // Check if the element is an input
//         if (ques.tagName.toLowerCase() === 'input') {
//             ques.focus();
//         }
//     }
// }
function scrollToQues2(ques_id, e) {
    e.preventDefault(); // Prevent the default jump-to-anchor behavior

    let ques = document.getElementById(ques_id);

    if (ques) {
        // Remove 'active' class from all question descriptions
        document
            .querySelectorAll(".test-panel__question-desc")
            .forEach((desc) => {
                desc.classList.remove("active");
            });

        // Add 'active' class to the current question description
        let questionDesc = ques.closest(".test-panel__question-desc");
        if (questionDesc) {
            questionDesc.classList.add("active");
        }

        // Scroll to the question
        let containers = document.querySelectorAll(".container__right");

        containers.forEach(function (container) {
            container.scroll({
                behavior: "smooth",
                top: ques.offsetTop - container.offsetTop - 20,
            });
        });

        // Check if the element is an input
        if (ques.tagName.toLowerCase() === "input") {
            ques.focus();
        }
    }
}

// Function to count words in the textarea
function countWords() {
    const textarea = document.getElementById("input1");
    const wordCount = document.querySelector(".writing-box__words-num_1");
    const text = textarea.value.trim();

    if (text === "") {
        wordCount.textContent = "0";
    } else {
        const words = text.split(/\s+/).filter((word) => word.length > 0);
        wordCount.textContent = words.length;
    }
}

// Add an input event listener to the textarea
document.getElementById("input1").addEventListener("input", countWords);

// Initial word count
countWords();

// Function to count words in the second textarea
function countWords2() {
    const textarea = document.getElementById("input2");
    const wordCount = document.querySelector(".writing-box__words-num_2");
    const text = textarea.value.trim();

    if (text === "") {
        wordCount.textContent = "0";
    } else {
        const words = text.split(/\s+/).filter((word) => word.length > 0);
        wordCount.textContent = words.length;
    }
}

// Add an input event listener to the second textarea
document.getElementById("input2").addEventListener("input", countWords2);

// Initial word count for the second textarea
countWords2();
