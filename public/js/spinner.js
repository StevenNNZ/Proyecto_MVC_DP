const Spinner = ()=>
{
    const spinner = document.createElement('div');

    spinner.classList.add('sk-folding-cube');
    spinner.innerHTML = `
    <div class="sk-cube1 sk-cube"></div>
    <div class="sk-cube2 sk-cube"></div>
    <div class="sk-cube4 sk-cube"></div>
    <div class="sk-cube3 sk-cube"></div>`;

    return spinner;
}

