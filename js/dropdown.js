function f() {
  document.getElementsByClassName('dropdown')[0].classList.toggle('down');
  document.getElementsByClassName('arrow')[0].classList.toggle('gone');
  if (document.getElementsByClassName('dropdown')[0].classList.contains('down')) {
    setTimeout(function() {
      document.getElementsByClassName('dropdown')[0].style.overflow = 'visible'
    }, 500)
  } else {
    document.getElementsByClassName('dropdown')[0].style.overflow = 'hidden'
  }
}
function ff() {
  document.getElementsByClassName('dropdownn')[0].classList.toggle('downn');
  document.getElementsByClassName('arroww')[0].classList.toggle('gone');
  if (document.getElementsByClassName('dropdownn')[0].classList.contains('downn')) {
    setTimeout(function() {
      document.getElementsByClassName('dropdownn')[0].style.overflow = 'visible'
    }, 500)
  } else {
    document.getElementsByClassName('dropdownn')[0].style.overflow = 'hidden'
  }
}