document.querySelector('button').addEventListener('click',() => {
  const li = document.createElement('li');
  const text = document.getElementById('post');
  li.textContent = text.value;
  document.querySelector('ul').appendChild(li);

  text.value = '';
  text.focus();
})














