class Block {  
  get block() {
    return this.generateBlock;
  }

  setCount( count = 0 ) {
    window.localStorage.setItem( 'cms-blocks-count', count );
  }

  getCount() {
    return Number( window.localStorage.getItem( 'cms-blocks-count' ) );
  }

  incrementCount() {
    this.setCount( this.getCount() + 1 );
  }

  decrementCount() {
    this.setCount( this.getCount() - 1 );
  }

  setAvailableBlocks( data = '' ) {
    window.localStorage.setItem( 'cms-available-blocks', JSON.stringify( data ) );
  }

  getAvailableBlocks() {
    return JSON.parse( window.localStorage.getItem( 'cms-available-blocks' ) );
  }

  setBlockType( type = '' ) {
    this.type = type;
  }

  getBlockType() {
    return this.type;
  }
  
  generateBlock( args = [] ) {
    const blocks          = this.getAvailableBlocks(),
          block           = this._block(),
          title           = this._h6(),
          collapse        = this._collapse(),
          remove          = this._remove(),
          blockContent    = this._content();

    if( blocks[this.type].fields.length > 0 ) {
      for (const key in blocks[this.type].fields) {
        const field           = blocks[this.type].fields[key],
              label           = this._label(field.name, field.label),
              row             = this._row(),
              inputField      = this._inputField();

        if( typeof args[key] != 'undefined' ) {
          inputField.appendChild( this.getField( field, args.length > 0 ? Object.values(args[key])[1] : '' ) )
        } else {
          inputField.appendChild( this.getField( field, '' ) )
        }

        row.appendChild( label );
        row.appendChild( inputField );
        blockContent.appendChild( row );
      }
    } else {
      const field           = blocks[this.type].fields,
            label           = this._label(field.name, field.label),
            row             = this._row(),
            inputField      = this._inputField();
            
      inputField.appendChild( this.getField( field, args.length > 0 ? Object.values(args[key])[1] : '' ) )
      
      row.appendChild( label );
      row.appendChild( inputField );
      blockContent.appendChild( row );
    }
    
    title.appendChild( remove );
    title.appendChild( collapse );

    block.appendChild( title );
    block.appendChild( blockContent );

    return block;
  }

  getField( field, value ) {
    let input = new Document();

    switch (field.type) {
      case 'textarea':
          input = document.createElement( 'textarea' );
          input.setAttribute("rows", field.rows ? field.rows : 10);
          input.innerText = field.placeholder;
        break;
    
      default:
          input = document.createElement( 'input' );
          input.setAttribute("type", 'text' );
          input.placeholder = field.placeholder;
        break;
    }

    input.id = field.name;
    input.value = value;
    input.classList.add( 'form-control' );
    input.setAttribute("name", field.name);

    return input;
  }

  saveBlocks() {
    const list = document.getElementById( 'draggable-list' );
    let selectedBlocks = [];
    
    for (let item of list.children) {
      const blockType = item.children[0].dataset.block
      const items = item.querySelectorAll( '.form-control' )

      let fields = []
      
      for (const field of items) {
        fields.push({
          field: field.getAttribute( 'name' ),
          value: field.value,
        });
      }

      selectedBlocks.push({
        type: blockType,
        fields: fields
      })
    }

    this.request( 'save.php', { blocks: JSON.stringify(Object.assign({}, selectedBlocks)), site: 1 }, 'POST' )
    .then( json => {
      const response = JSON.parse( json );
      this.showMessage( response.message, response.success )
    });
  }

  previewBlocks() {
    const list = document.getElementById( 'draggable-list' );
    let selectedBlocks = [];
    
    for (let item of list.children) {
      const blockType = item.children[0].dataset.block
      const items = item.querySelectorAll( '.form-control' )

      let fields = []
      
      for (const field of items) {
        fields.push({
          field: field.getAttribute( 'name' ),
          value: field.value,
        });
      }

      selectedBlocks.push({
        type: blockType,
        fields: fields
      })
    }

    const input = document.getElementById( 'template' );
    input.value = JSON.stringify(Object.assign({}, selectedBlocks))

    const template_id = document.getElementById( 'template-id' );
    template_id.value = '';

    const form = document.getElementById( 'template-form' );
    form.submit();

    // iframe.src = `https://cms.test/view.php?blocks=${JSON.stringify(Object.assign({}, selectedBlocks))}`;
  }

  showMessage( message, success = true ) {
    const alert = document.getElementById( 'alert' );
    alert.innerHTML = message;
    alert.classList.add( success ? 'alert-success' : 'alert-danger' );
    alert.classList.remove( 'd-none' );

    setTimeout( () => {
      alert.classList.remove( 'alert-success' );
      alert.classList.remove( 'alert-danger' );
      alert.classList.add( 'd-none' );
    }, 5000)
  }

  removeBlock( element ) {
    element.target.closest( ' li ' ).remove()

    const target  = document.getElementById( 'drop-area' ),
          count   = target.children[0].children.length
    
    this.decrementCount();

    if( count < 1 ) {
      const button = document.getElementById( 'btn-save' )
      button.classList.add( 'disabled' )
      button.disabled = true;
    }
  }

  generateBlockOptions() {
    const keys = Object.keys( this.getAvailableBlocks() ),
          list = document.getElementById( 'cms-blocks-list' )

    for ( let i = 0; i < keys.length; i++ ) {
        const item = this._li( keys[i] );

        list.append( item )
    }
  }

  init( blocks = null ) {
    this.request( 'blocks.json' )
    .then( response => {
      // Save available blocks into localStorage
      this.setAvailableBlocks( response.blocks[0] )

      // Generate available blocks
      this.generateBlockOptions( )

      // Populate existing template blocks
      if( blocks ) {
        Object.values( blocks ).map( block => {
          this.type = block.type
  
          const dom = document.createElement( 'li' );
          dom.classList.add( 'list-group-item' );
          dom.classList.add( 'p-0' );
          dom.classList.add( 'mb-2' );
          dom.appendChild( this.generateBlock( JSON.parse( block.fields ) ) );
  
          const target = document.getElementById( 'drop-area' )
          target.children[0].append( dom )
          this.incrementCount();
  
          const saveButton = document.getElementById( 'btn-save' )
          saveButton.classList.remove( 'disabled' )
          saveButton.disabled = false;
        })
      }
    });
  }

  async request( url = '', data = {}, method = 'POST' ) {
    return await $.ajax({
      type: method,
      url: url,
      data: data
    });
  }

  _li( el ) {
    const list = document.createElement( 'li' );
    list.innerHTML = el.replaceAll("-", " ").replace(/(^\w{1})|(\s+\w{1})/g, letter => letter.toUpperCase());
    // list.classList.add( 'list-group-item' );
    list.classList.add( 'draggable' );
    list.classList.add( 'cursor-pointer' );
    list.setAttribute( 'data-type', el)
    list.setAttribute( 'draggable', true)
    list.addEventListener( 'dragstart', dragStart, false);
    list.addEventListener( 'dragend', dragEnd, false);
    return list;
  }

  _h6() {
    const h6 = document.createElement( 'h6' );
    h6.innerHTML = this.type.replaceAll("-", " ").replace(/(^\w{1})|(\s+\w{1})/g, letter => letter.toUpperCase());
    h6.classList.add( 'mb-0' );
    h6.classList.add( 'p-2' );
    h6.classList.add( 'border-bottom' );
    h6.classList.add( 'bg-light' );
    return h6;
  }

  _collapse() {
    const btn = document.createElement( 'button' );
    btn.innerHTML = '<i aria-hidden="true" class="fa fa-caret-up"></i>';
    btn.classList.add( 'close' );
    btn.classList.add( 'collapsable' );
    btn.setAttribute( 'type', 'button' );
    btn.setAttribute( 'data-toggle', 'collapse' );
    btn.setAttribute( 'data-target', `#${this.type}-${this.getCount()}`);
    btn.setAttribute( 'data-expanded', 'false' );
    btn.setAttribute( 'data-controls', `${this.type}-${this.getCount()}`);
    return btn;
  }

  _remove() {
    const btn = document.createElement( 'button' );
    btn.innerHTML = '<i aria-hidden="true" class="fa fa-times"></i>';
    btn.classList.add( 'close' );
    btn.classList.add( 'remove' );
    btn.classList.add( 'pl-2' );
    btn.classList.add( 'mt-1' );
    btn.style.fontSize = "16px";
    btn.style.color = "red";
    return btn;
  }

  _content() {
    const content = document.createElement( 'div' );
    content.classList.add( 'collapse' );
    content.classList.add( 'show' );
    content.classList.add( 'mt-3' );
    content.classList.add( 'px-3' );
    content.id = `${this.type}-${this.getCount()}`;
    return content;
  }

  _block() {
    const block = document.createElement( 'div' );
    block.setAttribute( 'data-block', this.type );
    return block;
  }

  _row() {
    const row = document.createElement( 'div' );
    row.classList.add( 'row' );
    row.classList.add( 'form-group' );
    return row;
  }

  _label(n, l) {
    const label = document.createElement( 'label' );
    label.classList.add( 'col-md-2' );
    label.classList.add( 'control-label' );
    label.setAttribute("for", n);
    label.innerHTML = l;
    return label;
  }

  _inputField() {
    const div = document.createElement( 'div' );
    div.classList.add( 'col-md-10' );
    return div;
  }
}