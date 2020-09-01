<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" href="<?php echo base_url(); ?>dashboard/">Quiz</a>
    <a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
    <ul class="app-nav">
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i
            class="fa fa-user fa-lg"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li>
                    <a class="dropdown-item" href="<?php echo base_url(); ?>change-password"><i
                        class="fa fa-key fa-lg"></i> Change Password</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>logout"><i class="fa fa-sign-out fa-lg"></i>Logout</a>
                    </li>
                </ul>
            </li>
        </ul>
    </header>

    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">

        <div class="app-sidebar__user">
            <center><img src="<?php echo base_url(); ?>assets/images/oncquest.png" alt="PCBT"
               style="height:100px; width:200px;"></center>
               <div>
                <!-- <p class="app-sidebar__user-designation">Welcome! Admin</p> -->
            </div>
        </div>

        <ul class="app-menu">
            <?php //echo $this->uri->segment(1); ?>
            <li>
                <a class="app-menu__item" href="<?php echo base_url(); ?>dashboard"><i
                    class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span>
                </a>
            </li>

            <li>
                <a class="app-menu__item" href="<?php echo base_url(); ?>user-management"><i
                    class="app-menu__icon fa fa-users"></i><span class="app-menu__label">User Management</span>
                </a>
            </li>

            <li>
                <a class="app-menu__item" href="<?=base_url('payments');?>"><i class="app-menu__icon fa fa-inr"></i><span class="app-menu__label">Payment History</span>
                </a>
            </li>

            <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-university"></i><span class="app-menu__label">Question Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
                <ul class="treeview-menu">
                    <li><a class="treeview-item" href="<?php echo base_url();?>categories"><i class="icon fa fa-circle-o"></i>Category List</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url();?>levels"><i class="icon fa fa-circle-o"></i>Level List</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url();?>question-bank"><i class="icon fa fa-circle-o"></i>Question Bank</a></li>
                    <li><a class="treeview-item" href="<?php echo base_url();?>pre-add-question"><i class="icon fa fa-circle-o"></i>Add
                    New Question</a></li>
                    <li><a class="treeview-item" data-toggle="modal" data-target="#uploadQuestion" href="javascript:void(0)"><i class="icon fa fa-circle-o"></i>Upload question</a></li>
                </ul>
            </li>

            <li>
                <a class="app-menu__item" href="<?php echo base_url(); ?>quiz-management"><i
                    class="app-menu__icon fa fa-server"></i><span class="app-menu__label">Quiz Management</span>
                </a>
            </li>

            <li>
                <a class="app-menu__item"
                href="<?php echo base_url('admin_package'); ?>"><i
                class="app-menu__icon fa fa-product-hunt"></i><span
                class="app-menu__label">Package Management</span>
            </a>
        </li>

        <li>
            <a class="app-menu__item" href="<?php echo base_url(); ?>report"><i
                class="app-menu__icon fa fa-area-chart"></i><span class="app-menu__label">Result Management</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="<?php echo base_url(); ?>admin-appreciation"><i
                class="app-menu__icon fa fa-area-chart"></i><span class="app-menu__label">Appreciation Management</span>
            </a>
        </li>
        <li>
            <a class="app-menu__item" href="<?php echo base_url(); ?>cache-clear"><i
                class="app-menu__icon fa fa-area-chart"></i><span class="app-menu__label">Clear Cache</span>
            </a>
        </li>
        
    </ul>
</aside>