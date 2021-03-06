<!-- Social Dialog Modal -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/it_IT/sdk.js#xfbml=1&version=v3.0';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>


<div class="modal fade" id="socialDialog" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="text-center text-primary">SHARE</h3>
                <div class="list-group list-group-flush">
                    <a href="#" class="list-group-item"><i class="fab fa-twitter fa-2x mr-3 "></i> <span class="text-muted">Twitter</span></a>
                    <a href="#" class="list-group-item"><i class="fab fa-facebook fa-2x mr-3 "></i> <span class="text-muted">
                        <div class="fb-like" data-href="<?php echo $rpm->data->url; ?>" data-layout="button" data-action="like" data-size="large" data-show-faces="false" data-share="false"></div>
                    </span></a>
                    <a href="#" class="list-group-item"><i class="fab fa-google-plus fa-2x mr-3 "></i> <span class="text-muted">Google Plus</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
