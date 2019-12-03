import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { LoginPage } from '../login/login';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { DataResponse } from '../../components/DataResponse';

/**
 * Generated class for the ValidatPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-validat',
  templateUrl: 'validat.html',
})
export class ValidatPage {
  mobile: any;
  email: any;
  mobileCode: any;
  emailCode: any;
  isValid: boolean = false;

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public global: Global,
    public http: HttpClient) {
    this.mobile = navParams.get('mobile');
    this.email = navParams.get('email');
  }

  ionViewDidLoad() {
    console.log(this.mobile);
    console.log(this.email);
  }

  goBack() {
    this.navCtrl.setRoot(LoginPage)
  }

  validatMobile(){
    if(this.mobileCode!=''){
      this.global.loadingSpinner();
      this.http.post(this.global.url+'valid-mob', {code: this.mobileCode, mobile:this.mobile })
      .toPromise()
      .then((data:DataResponse<any>)=>{
        this.global.customLoading.dismiss();
        if(data['success']!=null){
          this.global.alertMsg('success', 'account_activation');
          this.navCtrl.setRoot(LoginPage);
        }else{
          this.global.alertMsg('error', 'wrong_code');
        }
      })
      .catch(error => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
    }else{
      this.global.alertMsg('error', 'code_empty');
    }
  }

  validatEmail(){
    if(this.emailCode!=''){
      this.global.loadingSpinner();
      this.http.post(this.global.url+'valid-mob', {code: this.emailCode, email:this.email })
      .toPromise()
      .then((data:DataResponse<any>)=>{
        this.global.customLoading.dismiss();
        if(data['success']!=null){
          this.global.alertMsg('success', 'account_acctivation');
          this.navCtrl.setRoot(LoginPage);
        }else{
          this.global.alertMsg('error', 'wrong_code');
        }
      })
      .catch(error => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
    }else{
      this.global.alertMsg('error', 'code_empty');
    }
  }

}
