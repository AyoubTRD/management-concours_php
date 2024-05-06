const searchForm = document.querySelector("#search-form");
const searchInput = document.querySelector("#search");

const textSearchP = document.querySelector("#search-text");

const tableau = document.querySelector("table");

const loadingContainer = document.querySelector("#loading-container");

function displayLoading() {
  tableau.style.display = "none";
  loadingContainer.style.display = "flex";
}

function hideLoading() {
  tableau.style.display = "table";
  loadingContainer.style.display = "none";
}

function displayData(search, resultats) {
  if (search) {
    const messageDeRecherche =
      resultats.length +
      " resultats de recherche pour: <em>" +
      search +
      "</em>.";

    textSearchP.innerHTML = messageDeRecherche;
    textSearchP.style.display = "block";
  } else {
    textSearchP.style.display = "none";
  }

  const tbody = tableau.querySelector("tbody");
  const html = resultats.reduce(
    (total, resultat) =>
      total +
      `
      <tr>
            <td>
              ${resultat.id}
            </td>
            <td>
              ${resultat.email}
            </td>
            <td>
              ${resultat.nom}
            </td>
            <td>
              ${resultat.prenom}
            </td>
            <td>
              ${resultat.date_naissance}
            </td>
            <td>
              ${resultat.etablissement}
            </td>
            <td>
              ${resultat.diplome}
            </td>
            <td>
              ${resultat.niveau}
            </td>
            <td>
                <a href="${encodeURI(resultat.cv)}" target="_blank">Ouvrir</a>
            </th>
            <td>
                    <div>
                        <a href="${resultat.photo_identite_recto}" target="_blank">Ouvrir Recto</a>
                    </div>
                    <div>
                      <a href="${resultat.photo_identite_verso}" target="_blank">Ouvrir Verso</a>
                    </div>
            </td>
        </tr>
    `,
    "",
  );

  tbody.innerHTML = html;
}

searchForm.onsubmit = async (e) => {
  e.preventDefault();
  displayLoading();
  try {
    const search = searchInput.value;

    const response = await fetch(
      "/searchInscriptions.php?search=" + encodeURI(search),
    );
    if (!response.ok) {
      alert("Erreur");
    }

    const data = await response.json();
    displayData(search, data);
  } catch (e) {
    console.error(e);
    alert("Erreur");
  } finally {
    hideLoading();
  }
};
