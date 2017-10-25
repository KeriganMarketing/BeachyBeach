<?php //QUICK SEARCH BOX ?>
<div id="smart-search-box">
	<div class="row">
		<form action="/property-search/" class="form-inline" method="get">
<div class="search-control"></div>
			<input type="hidden" name="q" value="search" >
			<div class="col-12">
				<div class="input-container smart-select">
					<div class="input-group input-group-lg">
						<select class="area-select form-control" name="city[]" id="id-area-select" multiple="multiple">
                        </select>
						<span class="input-group-btn">
                            <button type="submit" class="btn btn-primary " ><img src="/wp-content/themes/kmaidx/helpers/assets/searchicon.svg" alt="Search" ></button>
                        </span>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="input-container property-type-select">
                    <?php

//                    $typeArray = array(
//	                    'Single Family Home' => array('Detached Single Family'),
//	                    'Condo / Townhome' => array('Condominium','Townhouse','Townhomes'),
//	                    'Commercial' => array('Office','Retail','Industrial','Income Producing','Unimproved Commercial','Business Only','Auto Repair','Improved Commercial','Hotel/Motel'),
//	                    'Lots / Land' => array('Vacant Land','Residential Lots','Land','Land/Acres','Lots/Land'),
//	                    'Multi-Family Home' => array('Duplex Multi-Units','Triplex Multi-Units'),
//	                    'Rental' => array('Apartment','House','Duplex','Triplex','Quadruplex','Apartments/Multi-family'),
//	                    'Manufactured' => array('Mobile Home','Mobile/Manufactured'),
//	                    'Farms / Agricultural' => array('Farm','Agricultural','Farm/Ranch','Farm/Timberland'),
//	                    'Other' => array('Attached Single Unit','Attached Single Family','Dock/Wet Slip','Dry Storage','Mobile/Trailer Park','Mobile Home Park','Residential Income','Parking Space','RV/Mobile Park')
//                    );

                    ?>
					<select id="home-prop-type" class="prop-type-input form-control form-control-lg" name="class" ></select>
				</div>
			</div>
			<div class="col-md-8 hidden-sm-down">
                <label>Price Range</label>
				<div id="slider-range"></div>
				<p class="range-text">from <span class="slider-num" id="num1">$0</span> to <span class="slider-num" id="num2">5,000,000+</span></p>

			</div>
            <div class="col-6 col-md-4 hidden-md-up">
                <div class="input-container property-type-select">
                    <select id="min-price" class="select-other form-control"   >
                        <option value="" >Min Price</option>
	                    <?php for($i = 50000; $i < 5000000; $i+=50000){
		                    echo '<option value="' . $i . '">$' . number_format( $i, 0, ".", ",") . '</option>';
	                    } ?>
                    </select>
                </div>
            </div>
            <div class="col-6 col-md-4 hidden-md-up">
                <div class="input-container property-type-select">
                    <select id="max-price" class="select-other form-control"   >
                        <option value="" >Max Price</option>
	                    <?php for($i = 50000; $i < 10000000; $i+=50000){
		                    echo '<option value="' . $i . '">$' . number_format( $i, 0, ".", ",") . '</option>';
	                    } ?>
                    </select>
                </div>
            </div>
            <input hidden="hidden" id="ihf-minprice-homes" name="min_price" class="form-control ihf-search-form-input" type="hidden" value=""/>
            <input hidden="hidden" id="ihf-maxprice-homes" name="max_price" class="form-control ihf-search-form-input" type="hidden" value=""/>
            <input type="hidden" name="sortBy" value="date_modified">
            <input type="hidden" name="orderBy" value="ASC">
		</form>
	</div>
</div>

