// var btn = document.querySelector('.add');
// var remove = document.querySelector('.draggable');
const block = new Block( )

function allowDrop(ev) {
    ev.preventDefault();
  }
 
function dragStart(e) {
    this.style.opacity = '0.4';
    block.setBlockType( e.target.dataset.type )
};
 
function dragDrop(e) {
    const dom = document.createElement('li');
	dom.classList.add('list-group-item');
	dom.classList.add('p-0');
    dom.classList.add('mb-2');
    dom.appendChild( block.block() );

    block.incrementCount();

    const target = document.getElementById('drop-area')
    target.children[0].append( dom )
    target.scrollTop = target.scrollHeight - target.clientHeight;

    const button = document.getElementById('btn-view')
    button.classList.remove('disabled')
    button.disabled = false;
}
 
function dragEnd(e) {
    this.style.opacity = '1';
}