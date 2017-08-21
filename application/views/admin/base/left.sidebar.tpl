            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </li>

                        {{ menu | raw }}

                        {% if session.userdata.level == 'A' %}

                        <li>
                            <a href="{{ base_url() }}admin/contributor"><i class="fa fa-gear fa-fw"></i> Contributor</a>
                        </li>
                        <li>
                            <a href="{{ base_url() }}admin/subscriber"><i class="fa fa-gear fa-fw"></i> Subscriber</a>
                        </li>
                        <li>
                            <a href="{{ base_url() }}admin/configuration"><i class="fa fa-gear fa-fw"></i> SEO | Sitemap | FP</a>
                        </li>
                        <li>
                            <a href="{{ base_url() }}admin/loguser"><i class="fa fa-gear fa-fw"></i> Log Visitor</a>
                        </li>
                        
                        {% endif %}
                        
                    </ul>
                </div>
            </div>
        </nav>