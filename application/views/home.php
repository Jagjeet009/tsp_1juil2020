<?php //print_r($surveys_list);?>
      <header>
        <h2>Create surveys easily. Get answers fast.</h2>
      </header>
      <p>Track, analyze and optimize your surveys.</p>
      <div class="row features">
        <section class="4u 12u(narrower) feature">
          <div class="image-wrapper first"></div>
			<a href="<?php 
			if($this->session->userdata('user_logged_id')){
				if(sizeof($surveys_list)>0){
					echo "javascript:createOrExistSurvey()";
				}else{
					echo "javascript:createSurvey()";
				}
			}else{
				echo "javascript:alert('Please Login')";
			}?>">
              <div class="survey-flow">
				<p>
				<?php 
				if($this->session->userdata('user_logged_id')){
					if(sizeof($surveys_list)>0){
						echo "Design Survey";
					}else{
						echo "Create Survey";
					}
				}else{
					echo "Create Survey";
				}?></p>
                  <img align="center" src="<?php echo base_url();?>theme/images/survey-create.png" height="100" />
              </div>
          </a>
        </section>
        <section class="4u 12u(narrower) feature">
          <div class="image-wrapper"></div>
          <a href="<?php if($this->session->userdata('user_logged_id')){echo "javascript:fillSurvey()";}else{echo "javascript:alert('Please Login')";}?>">
              <div class="survey-flow">
                  <p>Fill Survey</p>
                  <img align="center" src="<?php echo base_url();?>theme/images/survey-fill.png" height="100" />
              </div>
          </a>
        </section>
        <section class="4u 12u(narrower) feature">
          <div class="image-wrapper"></div>
          <a href="<?php if($this->session->userdata('user_logged_id')){echo "javascript:analyticsSurvey()";}else{echo "javascript:alert('Please Login')";}?>">
              <div class="survey-flow">
                  <p>Analyse Survey</p>
                  <img align="center" src="<?php echo base_url();?>theme/images/survey-analyse.png" height="100" />
              </div>
          </a>
        </section>
      </div>
