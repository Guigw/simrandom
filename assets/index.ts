import _ from 'lodash';
function component(){
    const element = document.createElement('div');

    element.innerHTML = _.join(['<h1>Sims', 'Randomizer</h1>'], ' ');
    return element;
}

document.body.appendChild(component());