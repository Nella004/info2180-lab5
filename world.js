window.onload = function() {
    const button = document.getElementById('lookup');
    button.addEventListener('click', function() {
        const search = document.getElementById('country').value;
        fetch(`world.php?country=${search}`)
            .then(response => response.text())
            .then(data => {
                document.getElementById('result').innerHTML = data;
            });
    });
};

const cityButton = document.getElementById('lookup-cities');
cityButton.addEventListener('click', function() {
    const search = document.getElementById('country').value;
    fetch(`world.php?country=${search}&lookup=cities`)
        .then(response => response.text())
        .then(data => {
            document.getElementById('result').innerHTML = data;
        });
});
