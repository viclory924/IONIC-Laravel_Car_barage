import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { FormGroup, FormBuilder, Validators } from '@angular/forms';
import { DataResponse } from '../../components/DataResponse';
import { TranslateService } from '@ngx-translate/core';
import { ForgotPage } from '../forgot/forgot';
import { RegisterPage } from '../register/register';
import { HomePage } from '../home/home';
import { ActiveAccountPage } from '../active-account/active-account';

/**
 * Generated class for the LoginPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-login',
  templateUrl: 'login.html',
})
export class LoginPage {
  form: FormGroup;
  username: string;
  password: string;
  token: string;


  validation_messages = {
    'username': [
      { type: 'required', message: 'required' }
    ],
    'password': [
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

  ngOnInit() {
    this.form = this.formBuilder.group({
      username: [null, Validators.required],
      password: [null, Validators.required]
    });
  }

  isFieldValid(field: string) {
    return !this.form.get(field).valid && this.form.get(field).touched;
  }

  displayFieldCss(field: string) {
    return {
      "has-error": this.isFieldValid(field),
      "has-feedback": this.isFieldValid(field)
    };
  }

  ionViewDidLoad() { }

  openForgot() {
    this.navCtrl.setRoot(ForgotPage);
  }

  openRegister() {
    this.navCtrl.setRoot(RegisterPage);
  }


  login() {
    if (this.form.valid) {
      this.global.loadingSpinner();
      this.username = this.form.controls.username.value;
      this.password = this.form.controls.password.value;
      this.http
        .post(this.global.url + "login", {
          client_id: "4",
          client_secret: "nc0sdfBrF1a6wluFwJRdSaqDFNf4lrRf6IpbW9vg",
          username: this.username.toLowerCase(),
          password: this.password
        })
        .toPromise()
        .then((data: DataResponse<any>) => {
          this.global.customLoading.dismiss();
          if (data['success'] != null) {
            this.token = data.success["token"];
            console.log("111111111111111")
            console.log(this.token);
            localStorage.setItem('token', this.token);
            localStorage.setItem('name', data.success["name"]);
            if (data.success["image"] != '' && data.success["image"] != null) {
              localStorage.setItem('image', this.global.imagePath + data.success["image"]);
            } else {
              localStorage.setItem('image', '../assets/imgs/user.png');
            }
            if (data.success["type"] == 'admin' || data.success["type"] == 'customer') {
              localStorage.setItem('userType', 'customer');
            } else {
              localStorage.setItem('userType', 'workshop');
            }
            this.navCtrl.setRoot(HomePage);
          } else {
            this.global.alertMsg('error', 'need_activation');
            this.navCtrl.setRoot(ActiveAccountPage);
          }
        })
        .catch(error => {
          this.global.customLoading.dismiss();
          console.log(error)
          this.global.alertMsg('error', 'server_error');
        });
    }
  }

  goBack() {
    this.navCtrl.setRoot(HomePage)
  }

}
