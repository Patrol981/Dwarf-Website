function start() {
  const templates = document.getElementsByClassName("main-template");

  for (let t of templates) {
    document.addEventListener("mousemove", (e) => {
      rotateElement(e, t);
    });
  }
}

/**
 * Rotates the target element
 * @param {MouseEvent} event - mouse event
 * @param {HTMLElement} element - target html element
 */
function rotateElement(event, element) {
  const x = event.clientX;
  const y = event.clientY;

  const rect = element.getBoundingClientRect();

  const isInsideX = x >= rect.left - 10 && x <= rect.right + 10;
  const isInsideY = y >= rect.top + 10 && y <= rect.bottom - 10;

  if (isInsideX && isInsideY) {
    const middleX = rect.left + rect.width / 2;
    const middleY = rect.top + rect.height / 2;

    const offsetX = ((x - middleX) / middleX) * 45;
    const offsetY = ((y - middleY) / middleY) * 45;

    element.style.setProperty("--rotateX", offsetX + "deg");
    element.style.setProperty("--rotateY", -1 * offsetY + "deg");
  } else {
    element.style.setProperty("--rotateX", 0 + "deg");
    element.style.setProperty("--rotateY", 0 + "deg");
  }
}