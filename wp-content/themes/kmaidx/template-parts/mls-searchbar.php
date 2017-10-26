<?php
$mls   = new MLS();

?>
<hr>
<div class="search-bar-container">
    <form class="form-inline" method="get" id="mainsearch" >
        <div class="search-control"></div>
        <div class="search-bar">
            <div class="row">
                <input type="hidden" name="qs" value="search" >
                <div class="col-md-6">
                    <div class="input-container">
                        <select class="form-control select2-omni-field" name="omniField" >
                            <option value="">City, area, subdivision or zip</option>
                        </select>
                    </select>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="input-container">
                        <select class="form-control form-control-lg select2-property-type" name="propertyType" >
                            <option value="">Property type</option>
                            <option value="Single Family Home">Single Family Home</option>
                            <option value="Condo / Townhome">Condo / Townhome</option>
                            <option value="Commercial">Commercial</option>
                            <option value="Lots / Land">Lots / Land</option>
                            <option value="Multi-Family Home">Multi-Family Home</option>
                            <option value="Rental">Rental</option>
                            <option value="Manufactured">Manufactured</option>
                            <option value="Farms / Agricultural">Farms / Agricultural</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="col text-right">
                    <div class="input-container">
                    <div class="button-group">
                        <button type="button" class="btn btn-default dropdown-toggle " data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="toggler('advanced-menu');">Advanced</button>
                        <button type="submit" class="btn btn-primary " >Search</button>
                    </div>
                    </div>
                </div>
            </div>
	    </div>
        <div id="advanced-menu" class="advanced-menu hidden">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-6">
                    <div class="row">
                    <div class="col-sm-6 col-md-12 col-lg-6">
                        <label class="sr-only" for="min_price">Min Price</label>
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Min Price</div>
                            <select name="minPrice" id="min_price" class="form-control select-other" >
                            <option value="" >Any</option>
                            <?php for($i = 50000; $i < 5000000; $i+=50000){
	                            echo '<option value="' . $i . '">$' . number_format( $i, 0, ".", ",") . '</option>';
                            } ?>
                            </select>
                        </div>
                        <p></p>
                    </div>
                    <div class="col-sm-6 col-md-12 col-lg-6">
                        <label class="sr-only" for="PRICE_MAX">Max Price</label>
                        <div class="input-group mb-2 mb-sm-0">
                            <div class="input-group-addon">Max Price</div>
                            <select name="maxPrice" id="max_price" class="form-control select-other" >
                            <option value="" >Any</option>
	                            <?php for($i = 50000; $i < 10000000; $i+=50000){
		                            echo '<option value="' . $i . '">$' . number_format( $i, 0, ".", ",") . '</option>';
	                            } ?>
                            </select>
                        </div>
                        <p></p>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <label class="sr-only" for="TOT_HEAT_SQFT">Total H/C Sqft</label>
                            <div class="input-group mb-2 mb-sm-0">
                                <div class="input-group-addon">Total H/C Sqft</div>
                                <select name="sq_ft" id="sq_ft" class="form-control select-other" >
                                    <option value="" >Any</option>
	                                <?php for($i = 800; $i < 10000; $i+=200){
		                                echo '<option value="' . $i . '">' . number_format( $i, 0, ".", ",") . '</option>';
	                                } ?>
                                </select>
                            </div>
                            <p></p>
                        </div>
                        <div class="col-sm-6 col-md-12 col-lg-6">
                            <label class="sr-only" for="acreage">Acreage</label>
                            <div class="input-group mb-2 mb-sm-0">
                                <div class="input-group-addon">Acreage</div>
                                <select name="acreage" id="acreage" class="form-control select-other" >
                                    <option value="" >Any</option>
	                                <?php $acreageArray = array(
                                        '.5' => '1/2 or more acres',
                                        '1' => '1 or more acres',
                                        '2' => '2 or more acres',
                                        '5' => '5 or more acres',
                                        '10' => '10 or more acres',
                                        '20' => '20 or more acres',
                                        '30' => '30 or more acres',
                                        '40' => '40 or more acres',
                                        '50' => '50 or more acres'
                                    );

                                    foreach($acreageArray as $k => $v){
		                                echo '<option value="' . $k . '">' . $v . '</option>';
	                                } ?>
                                </select>
                            </div>
                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-lg-6">
                    <div class="radio-box">
                    <div class="row">
                        <label class="sr-only" for="bedrooms">Beds</label>
                        <div class="col-12 col-md-2 label input-group-addon" >Beds</div>
                        <div class="col form-check form-check-inline">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="bedrooms" value="" class="custom-control-input" >
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Any</span>
                            </label>
                            <?php for($i = 1; $i < 6; $i+=1){
                                echo '<label class="custom-control custom-radio">
                                <input type="radio" name="bedrooms" value="'.$i.'" class="custom-control-input" >
                                <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">'.$i.' +</span>
                              </label>';
                        } ?>
                        </div>
                    </div></div>
                    <div class="radio-box">
                    <div class="row">
                        <label class="sr-only" for="bathrooms">Baths</label>
                        <div class="col-12 col-md-2 label input-group-addon" >Baths</div>
                        <div class="col form-check form-check-inline">
                            <label class="custom-control custom-radio">
                                <input type="radio" name="bathrooms" value="" class="custom-control-input" >
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description">Any</span>
                            </label>
                            <?php for($i = 1; $i < 6; $i+=1){
                                echo '<label class="custom-control custom-radio">
                                <input type="radio" name="bathrooms" value="'.$i.'" class="custom-control-input" >
                                <span class="custom-control-indicator"></span>
                              <span class="custom-control-description">'.$i.' +</span>
                              </label>';
                            } ?>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="radio-box status">
                        <div class="row">
                            <?php $status = (isset($_GET['status']) ? $_GET['status'] : array()); ?>
                            <label class="sr-only" for="bathrooms">Status</label>
                            <div class="col-12 col-md-2 label input-group-addon" >Status</div>
                            <div class="col form-check form-check-inline">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" <?php echo (in_array('active',$status) ? 'checked' : ''); ?> name="status[]" value="active">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Active</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" <?php echo (in_array('sold',$status) ? 'checked' : ''); ?> name="status[]" value="sold">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Sold</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" <?php echo (in_array('pending',$status) ? 'checked' : ''); ?> name="status[]" value="pending">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Pending</span>
                                </label>
                                <?php ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="radio-box features">
                        <div class="row">
                            <label class="sr-only" for="bathrooms">Features</label>
                            <div class="col-12 col-md-2 label input-group-addon" >Features</div>
                            <div class="col form-check form-check-inline">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" <?php echo (isset($_GET['waterfront']) ? 'checked' : ''); ?> name="waterfront" value="1" >
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Waterfront</span>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" <?php echo (isset($_GET['pool']) ? 'checked' : ''); ?> name="pool" value="1">
                                    <span class="custom-control-indicator"></span>
                                    <span class="custom-control-description">Pool</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="sortBy" value="date_modified">
        <input type="hidden" name="orderBy" value="ASC">
    </form>

	<?php if (isset($_GET['qs'])) { ?>
        <div class="search-criteria">
            <form class="form form-inline text-right" method="get" >
			<?php
			if(isset($_GET['omniField']) && $_GET['omniField']!= '') {

				if(is_array($_GET['omniField'])){
					for($i=0;$i<count($_GET['omniField']);$i++){
						echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" ';
						echo ' data-call="omniField|' . urlencode(trim($_GET['omniField'][$i])) . '" >' . stripslashes( $_GET['omniField'][$i]);
						echo '</a><input type="hidden" name="omniField[]" value="'.stripslashes( $_GET['omniField'][$i] ).'" > ';
					}
				}

			}

			if(isset($_GET['status']) && $_GET['status']!= '') {

				if(is_array($_GET['status'])){
					for($i=0;$i<count($_GET['status']);$i++){
					    if($_GET['status'][$i]!='') {
						    echo '<a class="criterion btn btn-default btn-sm hidden-sm-down"';
						    echo ' data-call="status|' . urlencode( trim( $_GET['status'][ $i ] ) ) . '" >' . stripslashes( $_GET['status'][ $i ] );
						    echo '</a><input type="hidden" name="status[]" value="' . stripslashes( $_GET['status'][ $i ] ) . '" > ';
					    }
					}
				}

			}

			if(isset($_GET['pool']) && $_GET['pool']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="pool" >Pool</a><input type="hidden" name="pool" value="'.$_GET['pool'].'" > ';
			}
			if(isset($_GET['waterfront']) && $_GET['waterfront']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="waterfront" >Waterfront</a><input type="hidden" name="waterfront" value="'.$_GET['waterfront'].'" > ';
			}
			if(isset($_GET['class']) && $_GET['class']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="class" >' . $_GET['class'] . '</a><input type="hidden" name="class" value="'.$_GET['class'].'" > ';
			}
			if(isset($_GET['min_price']) && $_GET['minPrice']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="min_price" >$' . number_format($_GET['min_price']) . ' Min</a><input type="hidden" name="min_price" value="'.$_GET['min_price'].'" > ';
			}
			if(isset($_GET['max_price']) && $_GET['maxPrice']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="max_price" >$' . number_format($_GET['max_price']) . ' Max</a><input type="hidden" name="max_price" value="'.$_GET['max_price'].'" > ';
			}
			if(isset($_GET['bedrooms']) && $_GET['bedrooms']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="bedrooms" >' . $_GET['bedrooms'] . '+ Beds</a><input type="hidden" name="bedrooms[ value="'.$_GET['bedrooms'].'" > ';
			}
			if(isset($_GET['bathrooms']) && $_GET['bathrooms']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="bathrooms" >' . $_GET['bathrooms'] . '+ Baths</a><input type="hidden" name="bathrooms" value="'.$_GET['bathrooms'].'" > ';
			}
			if(isset($_GET['sq_ft']) && $_GET['sq_ft']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="sq_ft" >' . $_GET['sq_ft'] . '+ Sqft</a><input type="hidden" name="sq_ft" value="'.$_GET['sq_ft'].'" > ';
			}
			if(isset($_GET['acreage']) && $_GET['acreage']!= '') {
				echo '<a class="criterion btn btn-default btn-sm hidden-sm-down" data-call="acreage" >' . $_GET['acreage'] . '+ Acres</a><input type="hidden" name="acreage" value="'.$_GET['acreage'].'" > ';
			}

			?>
                <div id="sortbox" class="ml-auto">
                    <div class="input-group input-group-sm">
                        <select class="form-control form-control-sm" name="sortBy" >
                            <option value="date_modified" <?php if($_GET['sortBy']=='date_modified'){ echo 'selected'; } ?> >Updated</option>
                            <option value="price" <?php if($_GET['sortBy']=='price'){ echo 'selected'; } ?>>Cheapest</option>
                            <!--<option value="list_date">Newest</option>-->
                        </select>
                        <span class="input-group-btn"><button type="submit" class="btn btn-sm btn-default" >Sort</button></span>
                    </div>
<!--                    <a class="rembutton btn btn-danger btn-sm pull-right" href="/property-search/" >reset</a>-->
                </div>
                <input type="hidden" name="orderBy" value="ASC">
                <input type="hidden" name="q" value="search" >
            </form>
        </div>
	<?php } ?>

</div>
<script type="text/javascript">

    function removeParam(key, sourceURL) {
        var arrayString = '|',
            rtn = sourceURL.split("?")[0],
            param,
            paramval,
            keyparts,
            params_arr = [],
            queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";

	    if(key.indexOf(arrayString) != -1){

            if (queryString !== "") {
                params_arr = queryString.split("&");
                for (var i = params_arr.length - 1; i >= 0; i -= 1) {

                    keyparts = key.split("|");
                    param = params_arr[i].split("=")[0];
                    paramval = params_arr[i].split("=")[1];

                    if (paramval === keyparts[1] ) {
                        console.log(paramval);
                        params_arr.splice(i, 1);
                    }
                }
                rtn = rtn + "?" + params_arr.join("&");
            }

        }else {

            if (queryString !== "") {
                params_arr = queryString.split("&");
                for (var i = params_arr.length - 1; i >= 0; i -= 1) {
                    param = params_arr[i].split("=")[0];
                    if (param === key) {
                        params_arr.splice(i, 1);
                    }
                }
                rtn = rtn + "?" + params_arr.join("&");
            }

        }

        //return rtn;
        window.location = rtn;
    }

</script>
