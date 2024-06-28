async function getAll() {
    try {
        const response = await fetch('getAll.php');
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json(); 
        const names = data.map(item => item.name);
        return names; 
    } catch (error) {
        console.error('There has been a problem with your fetch operation:', error);
    }
}

function levenshtein(a, b) {
    const matrix = [];

    for (let i = 0; i <= b.length; i++) {
        matrix[i] = [i];
    }

    for (let j = 0; j <= a.length; j++) {
        matrix[0][j] = j;
    }

    for (let i = 1; i <= b.length; i++) {
        for (let j = 1; j <= a.length; j++) {
            if (b.charAt(i - 1) === a.charAt(j - 1)) {
                matrix[i][j] = matrix[i - 1][j - 1];
            } else {
                matrix[i][j] = Math.min(
                    matrix[i - 1][j - 1] + 1, // substitution
                    matrix[i][j - 1] + 1,     // insertion
                    matrix[i - 1][j] + 1      // deletion
                );
            }
        }
    }

    return matrix[b.length][a.length];
}

async function search() {
    let search = document.querySelector("#search").value.toLowerCase();

    try {
        let names = await getAll();

        let exactMatches = names.filter(name => name.toLowerCase().includes(search));
        let similarMatches = names
            .map(name => ({
                name: name,
                distance: levenshtein(name.toLowerCase(), search)
            }))
            .filter(item => item.distance <= 2 && !exactMatches.includes(item.name))
            .sort((a, b) => a.distance - b.distance)
            .map(item => item.name);

        let results = exactMatches.concat(similarMatches);

        for(let i = 0; i < results.length; i++){
            results[i] = results[i].toLowerCase();
        }

        let allCards = document.querySelectorAll('.card_add');
        allCards.forEach(card => {
            console.log(results)
            console.log(card.id.toLowerCase());
            console.log(results.includes(card.id.toLowerCase()));
            if(!((results.includes(card.id.toLowerCase()))) && !(search == "")){
                card.style.display = "none";
            }else{
                card.style.display = "block";
            }
        })
    } catch (error) {
        console.error('There has been a problem with the search operation:', error);
    }
}
