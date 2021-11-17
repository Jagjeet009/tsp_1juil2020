<!--      <header>
        <h2>Create surveys easily. Get answers fast.</h2>
      </header>
      <p>Track, analyze and optimize your surveys.</p>-->
      <div class="row features">
        <section class="4u 12u(narrower) feature">
          <div class="image-wrapper first"></div>
          <a href="<?php if($this->session->userdata('user_logged_id')){echo "";}else{echo "javascript:selectSurvey()";}?>">
              <div class="survey-flow">
                  <p>Design Survey</p>
                  <img align="center" src="<?php echo base_url();?>theme/images/survey-create.png" height="100" />
              </div>
          </a>
        </section>
        <section class="4u 12u(narrower) feature">
          <div class="image-wrapper"></div>
          <a href="">
              <div class="survey-flow no-work">
                  <p>Fill Survey</p>
                  <img align="center" src="<?php echo base_url();?>theme/images/survey-fill.png" height="100" />
              </div>
          </a>
        </section>
        <section class="4u 12u(narrower) feature">
          <div class="image-wrapper"></div>
          <a href="">
              <div class="survey-flow no-work">
                  <p>Analyse Survey</p>
                  <img align="center" src="<?php echo base_url();?>theme/images/survey-analyse.png" height="100" />
              </div>
          </a>
        </section>
      </div>
