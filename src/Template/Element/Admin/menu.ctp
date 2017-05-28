<div class="menu-principal">
    <nav class="menu nav flex-column">
        <a href="<?php echo $this->Url->build(array('controller'=>'home','action'=>'index')) ?>" 
            class="nav-link dashboard <? echo ($this->request->controller === 'Home') ? 'active' : '' ; ?>">
            <i class="icon-home"></i> Dashboard
        </a>
        <a href="#" class="nav-link heading">General</a>
        <a href="<?php echo $this->Url->build(array('controller'=>'pages','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Pages') ? 'active' : '' ; ?>">
            <i class="icon-book-open"></i> Pages
        </a>
        <a href="<?php echo $this->Url->build(array('controller'=>'articles','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Articles') ? 'active' : '' ; ?>">
            <i class="icon-layers"></i> Articles
        </a>
        <a href="<?php echo $this->Url->build(array('controller'=>'contacts','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Contacts') ? 'active' : '' ; ?>">
            <i class="icon-envelope"></i> Contact Request
        </a>
        <a href="<?php echo $this->Url->build(array('controller'=>'users','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Users') ? 'active' : '' ; ?>">
            <i class="icon-user"></i> Users
        </a>
        <a href="#" class="nav-link heading">Agenda</a>
        <a href="<?php echo $this->Url->build(array('controller'=>'todos','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Todos') ? 'active' : '' ; ?>">
            <i class="icon-pin"></i> Todos
        </a>
        <a href="#" class="nav-link heading">Careers</a>
        <a href="<?php echo $this->Url->build(array('controller'=>'positions','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Positions') ? 'active' : '' ; ?>">
            <i class="icon-notebook"></i> Positions
        </a>
        <a href="<?php echo $this->Url->build(array('controller'=>'postulations','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Postulations') ? 'active' : '' ; ?>">
            <i class="icon-drawer"></i> Postulations
        </a>
        <!-- Todo in a new version -->
        <!-- <a href="#" class="nav-link heading">Galleries</a>
        <a href="" 
            class="nav-link <? echo ($this->request->controller === 'Categories') ? 'active' : '' ; ?>">
            <i class="icon-list"></i> Categories
        </a>
        <a href="" 
            class="nav-link <? echo ($this->request->controller === 'Images') ? 'active' : '' ; ?>">
            <i class="icon-camera"></i> Images
        </a> -->
        <a href="#" class="nav-link heading">Config</a>
        <a href="<?php echo $this->Url->build(array('controller'=>'parameters','action'=>'index')) ?>" 
            class="nav-link <? echo ($this->request->controller === 'Parameters') ? 'active' : '' ; ?>">
            <i class="icon-settings"></i> Parameters
        </a>
    </nav>
</div>  