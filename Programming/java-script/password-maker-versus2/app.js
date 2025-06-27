const minuscules = [...'abcdefghijklmnopqrstuvwxyz'];
const majuscules = [...'ABCDEFGHIJKLMNOPQRSTUVW'];
const nombres = [...'0123456789'];
const special = [...'éù@#:;*/!?$~&-()'];
const cells = document.querySelectorAll('.cells');

// variables des inputs de type checkbox
const checkboxLowercase = document.getElementById('lowercase');
const checkboxUppercase = document.getElementById('uppercase');
const checkboxNumbers = document.getElementById('numbers');
const checkboxSymbols = document.getElementById('symbols');

//bouton du generateur du mot de pass
const generateButton = document.querySelector('#generateButton');
const passwordOutput = document.getElementById('password-output');
//variable pour tableau qui cumule les tableaux de caractères
let tableCharacters = [];
let randomCharacters;

let password = '';

//variables pour l'input de type range et text

const inputPasswordLenght = document.getElementById('password-length');
const lenghtPassword = document.getElementById('display-password-length');

//passage de la valeur de l'input de type  range à l'input de type text
inputPasswordLenght.addEventListener('input', () => {
  lenghtPassword.value = inputPasswordLenght.value;
});

// pour chaque input de type checkbox, dés lors que selectionner on pousse les caractéres d'une catégorie de caractéres (ex const minuscules =[]de caractères vers un tableau  tableCharacters qui cumule les tableaux

cells.forEach((cell) => {
  cell.addEventListener('input', () => {
    // utilisation du spread operator avec la condition sous forme ternaire
    checkboxLowercase.checked ? tableCharacters.push(...minuscules) : false;
    checkboxUppercase.checked ? tableCharacters.push(...majuscules) : false;
    checkboxNumbers.checked ? tableCharacters.push(...nombres) : false;
    checkboxSymbols.checked ? tableCharacters.push(...special) : false;
    if (tableCharacters.length === 0) {
      alert(
        'Merci de bien vouloir sélectionner au moins une catégorie de caractère'
      );
    }
  });
});

generateButton.addEventListener('click', () => {
  password = '';
  for (let index = 0; index < lenghtPassword.value; index++) {
    randomCharacters = Math.floor(Math.random() * tableCharacters.length);
    password += tableCharacters[randomCharacters];
    passwordOutput.value = password;
    console.log(password);
  }
  passwordOutput.select();
  navigator.clipboard.writeText(passwordOutput.value);
  generateButton.textContent = 'Copier votre code!';
  setTimeout(() => {
    generateButton.textContent = 'génèrer mot de passe ';
  }, 4000);
});
