<style>
    #overlayConc{

        position: fixed;
        /* Sit on top of the page content */
        display: none;
        /* Hidden by default */
        width: 100%;
     
        /* Full width (cover the whole page) */
        height: 100%;
        /* Full height (cover the whole page) */

      
 
        background-color: rgba(0, 0, 0, 0.5);
        /* Black background with opacity */
        z-index: 2;
        /* Specify a stack order in case you're using a different order for other elements */
        cursor: pointer;
        /* Add a pointer on hover */


    }
</style>


<div class="kt-content  kt-grid__item kt-grid__item--fluid " id="overlayConc" >
<div class="col-md-6" >

    <!--begin::Portlet-->
    <div class="kt-portlet">
        <div class="kt-portlet__head">

            <div class="kt-portlet__head-label">
                <h3 class="kt-portlet__head-title">
                    Conclude Issue
                </h3>
            </div>

            <a  onclick="offConc()" style="margin-top:10px;" class="btn btn-clean btn-sm btn-icon btn-icon-md">
                <i class="flaticon2-cancel-music"></i>
            </a>
        </div>

        <!--begin::Form-->
        <form class="kt-form kt-form--label-right" method="POST" action="/acoes/condition/concluded">
        @csrf


            <div class="kt-portlet__body">
            <input id="inputCodConc" name="idissue" type="hidden"></input>
                <div class="form-group form-group-last">
                    <label for="exampleTextarea">Concluded Remark</label>
                    <textarea name="conc" class="form-control"  rows="3">Escreve um comentário sobre a conclusão.</textarea>
                </div>





            </div>
            <div class="kt-portlet__foot">
                <div class="kt-form__actions">
                    <div class="row">
                        <div class="col-2">
                        </div>
                        <div class="col-10">
                            <button type="submit" class="btn btn-success">Conclude</button>
                            <button type="button" onclick="window.location.href='/acoes/revert/concluded/'+ document.getElementById('inputCodConc').value" class="btn btn-warning"> Back Processing</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    </form>
</div>
</div>
<!--end::Portlet-->