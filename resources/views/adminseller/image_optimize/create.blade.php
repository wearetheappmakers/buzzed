
<div class="kt-portlet__body">
    <div class="form-group row">
        <div class="col-lg-4">
        <?php $module_name = config('custom_setting.image_optimize_module_name'); ?>
        
            <label>Name:</label>
            <select class="form-control" name="module_name" required>
                <option value="">Select Module</option>
                @foreach($module_name as $name)
                    <option value="{{$name}}">{{$name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-lg-6">
            <table class="table table-striped- table-bordered table-hover table-checkabl">
                <thead>
                    <tr>
                        <td>#</td>
                        <td>Size</td>
                        <td>Width</td>
                        <td>Height</td>
                    </tr>
                </thead>
                <tbody>
                <?php $data1="" ?>
                @for($i=0;$i<4;$i++)
                <?php if($i==0){ $data1="Big"; } elseif ($i==1) { $data1 = "Medium"; } elseif ($i==2) { $data1 = "Small"; } elseif ($i==3) { $data1 = "Tiny"; } ?>
                     <tr>
                        <td>{{$i+1}}</td>
                        <td><input type="text" name="thumb_folder[]" class="form-control" value="{{ $data1 }}" readonly></td>
                        <td><input type="number" name="width[]" id="width" placeholder="Width" class="form-control"></td>	
                        <td><input type="number" name="height[]" id="height" placeholder="Height" class="form-control"></td>	
                    </tr>
                @endfor
                </tbody>
              
            </table>
        </div>
    </div>
    
</div>