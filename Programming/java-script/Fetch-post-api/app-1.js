const formulaire = document.getElementById('formulaire');
const prenom = document.getElementById('prenom');
const nom = document.getElementById('fullname');
const eMail = document.getElementById('mail');
const phone = document.getElementById('phone');

formulaire.addEventListener('submit', (e) => {
  e.preventDefault();
  fetch('https://685a93a59f6ef9611156f5a7.mockapi.io/users', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      prenom: prenom.value,
      nom: nom.value,
      eMail: eMail.value,
      phone: phone.value
    })
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      alert(`Utilisateur créé avec succès : ${JSON.stringify(data)}`);
    });
});
