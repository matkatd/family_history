const menu = document.querySelector(".dropdown");
const toDisplay = document.querySelector("#mobile-overlay");
const navText = document.querySelector(".nav-text ul");
const exit = document.querySelector(".exit");
menu.addEventListener("click", () => {
  toDisplay.classList.toggle("overlay");
  // toDisplay.style.display = "flex";
  // toDisplay.style.opacity = "1";
});

exit.addEventListener("click", () => {
  toDisplay.classList.toggle("overlay");
  // toDisplay.style.display = "none";
  // toDisplay.style.opacity = "0";
});
