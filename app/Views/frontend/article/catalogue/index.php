<div class="blog-page">
   <div class="blog-content">
        <div class="uk-container uk-container-center">
            <div class="uk-grid uk-grid-large">
                <div class="uk-width-small-1-1 uk-width-medium-3-4">
                    <div class="site-posts">
                     <?php
                        if(isset($article['list']) && is_array($article['list']) && count($article['list'])){
                        foreach($article['list'] as $key => $val){
                           $title = $val['title'];
                           $image = $val['image'];
                           $canonical = write_url($val['canonical']);
                           $description = $val['description'];
                           $created = changeDateFormat($val['created_at'], 'd/m/Y');
                     ?>

                        <article class="klb-article post-1035 post type-post status-publish format-standard has-post-thumbnail hentry category-tips-tricks tag-food tag-store tag-themeforest">
                            <div class="post-thumbnail">
                                <a class="image img-cover" href="<?php echo $canonical; ?>">
                                    <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
                                </a>
                            </div>

                            <div class="post-wrapper">
                                <div class="entry-meta">
                                    <span class="meta-item entry-published"><i class="klbth-icon-clock"></i><a href="<?php echo $canonical; ?>"><?php echo $created ?> </a></span>

                                    <span class="meta-item entry-published"><i class="klbth-icon-bookmark-empty"></i><a href="" rel="category tag"><?php echo $articleCatalogue['title'] ?></a></span>
                                </div>

                                <h2 class="entry-title"><a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a></h2>

                                <div class="entry-content">
                                    <div class="klb-post">
                                        <?php echo $description ?>
                                        <div class="klb-readmore entry-button"><a class="button" href="<?php echo $canonical; ?>">Xem thêm</a></div>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <?php }} ?>


                        <div class="col col-12">
                            <div class="site-pagination">
                                <?php echo (isset($article['pagination'])) ? $article['pagination'] : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-small-1-1 uk-width-medium-1-4">
                    <div class="aside-blog">
                       <?php if(isset($widget['post']) && is_array($widget['post']) && count($widget['post'])){ ?>
                        <div class="widget widget_popular_posts">
                            <h4 class="widget-title"><?php echo $widget['post']['title'] ?></h4>
                            <?php if(isset($widget['post']['object']) && is_array($widget['post']['object']) && count($widget['post']['object'])){ ?>
                            <div class="widget-body">
                                <div class="widget-posts">
                                   <?php
                                    foreach($widget['post']['object'] as $key => $val){
                                       $title = $val['title'];
                                       $image = $val['image'];
                                       $canonical = write_url($val['canonical']);
                                       $description = $val['description'];

                                      ?>

                                    <article class="post">
                                        <div class="post-thumbnail">
                                            <div class="post-number"><?php echo $key + 1; ?></div>
                                            <a class="image img-cover" href="<?php echo $canonical ?>">
                                                <img src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
                                            </a>
                                        </div>

                                        <div class="post-wrapper">
                                            <h2 class="entry-title">
                                                <a href="<?php echo $canonical; ?>" title="<?php echo $title; ?>">
                                                    <?php echo $title; ?>
                                                </a>
                                            </h2>
                                        </div>
                                    </article>
                                    <?php } ?>
                                </div>
                            </div>
                           <?php } ?>
                        </div>
                        <?php } ?>
                        <div class="widget widget_social_list">
                            <h4 class="widget-title">Social Media</h4>

                            <div class="widget-body">
                                <div class="site-social style-1 wide">
                                    <ul>
                                        <li>
                                            <a href="<?php echo $general['social_facebook'] ?>" class="facebook"><i class="klbth-icon-facebook"></i><span>facebook</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $general['social_twitter'] ?>" class="twitter"><i class="klbth-icon-twitter"></i><span>twitter</span></a>
                                        </li>
                                        <li>
                                            <a href="<?php echo $general['social_pinterest'] ?>" class="pinterest"><i class="klbth-icon-pinterest"></i><span>pinterest</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget-banner">
                            <a class="image img-cover" href="" title=""><img src="public/frontend/resources/img/sidebar-banner.gif"/></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
