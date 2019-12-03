import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TranslateService } from '@ngx-translate/core';
import { CarPage } from '../car/car';
import { DataResponse } from '../../components/DataResponse';

/**
 * Generated class for the CarManualPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-car-manual',
  templateUrl: 'car-manual.html',
})
export class CarManualPage {
  form: FormGroup;
  validation_messages = {
    'model': [
      { type: 'required', message: 'required' }
    ],
    'origin': [
      { type: 'required', message: 'required' }
    ],
    'eng_no': [
      { type: 'required', message: 'required' }
    ],
    'vehicle_type': [
      { type: 'required', message: 'required' }
    ],
    'chassis_no': [
      { type: 'required', message: 'required' }
    ]
  };

  constructor(public navCtrl: NavController, 
    public navParams: NavParams,
    public global: Global,
    public http: HttpClient,
    public formBuilder: FormBuilder,
    public translate: TranslateService) {
  }

  ionViewDidLoad() {
    
  }
  
  ngOnInit() {
    this.form = this.formBuilder.group({
      model:[null, Validators.required],
      origin:[null, Validators.required],
      eng_no:[null, Validators.required],
      vehicle_type:[null, Validators.required],
      chassis_no:[null, Validators.required]
    });
  }

  goBack() {
    this.navCtrl.setRoot(CarPage)
  }

  save(){
    if(this.form.valid){
      this.global.loadingSpinner();
      this.http.post(this.global.url+'car-add', this.form.value, {headers: this.global.oauthHeader})
      .toPromise()
      .then((data:DataResponse<any>)=>{
        this.global.customLoading.dismiss();
        if(data.error=='bad_request'){
          this.global.alertMsg('error', 'server_error');
        }else if(data.error=='success'){
          this.global.alertMsg('success', 'data_save');
          this.navCtrl.setRoot(CarPage);
        }
      })
      .catch(error => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
    }else{
      this.global.validateAllFormFields(this.form);
    }
  }

}
