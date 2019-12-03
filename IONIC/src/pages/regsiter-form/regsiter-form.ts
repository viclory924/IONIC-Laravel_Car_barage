import { Component } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { LoginPage } from '../login/login';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { TranslateService } from '@ngx-translate/core';
import { DataResponse } from '../../components/DataResponse';
import { ValidatPage } from '../validat/validat';

/**
 * Generated class for the RegsiterFormPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

@Component({
  selector: 'page-regsiter-form',
  templateUrl: 'regsiter-form.html',
})
export class RegsiterFormPage {
  form: FormGroup;
  registerType: string;

  validation_messages = {
    'name': [
      { type: 'required', message: 'required' },
      { type: 'minlength', message: 'minlength8' },
      { type: 'maxlength', message: 'maxlength200' },
      { type: 'pattern', message: 'pattern_text' }
    ],
    'mobile': [
      { type: 'required', message: 'required' }
    ],
    'email': [
      { type: 'required', message: 'required' },
      { type: 'pattern', message: 'pattern_email' }
    ],
    'password': [
      { type: 'required', message: 'required' },
      { type: 'minlength', message: 'minlength8' },
      { type: 'pattern', message: 'strong_password' }
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
    this.registerType = localStorage.getItem('userType');
  }

  ngOnInit() {
    this.form = this.formBuilder.group({
      name: [null, Validators.compose([
        Validators.required,
        Validators.pattern("([a-zA-Z|\u0600-\u06FF|0-9])([a-zA-Z|\u0600-\u06FF|0-9| /s ]*)$"),
        Validators.minLength(5),
        Validators.maxLength(200)
      ])],
      password: [
        null,
        Validators.compose([Validators.required,
        Validators.minLength(8),
        Validators.pattern("(?=^.{8,}$)(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$")])
      ],
      email: [
        null,
        Validators.compose([
          Validators.required,
          Validators.pattern('^[_A-Za-z0-9-\\+]+(\\.[_A-Za-z0-9-]+)*@[A-Za-z0-9-]+(\\.[A-Za-z0-9]+)*(\\.[A-Za-z]{2,})$')
        ])
      ],
      mobile: [
        null, 
        Validators.compose([
          Validators.required
        ])
      ],
      type:[null, null]
    });
  }

  goBack() {
    this.navCtrl.setRoot(LoginPage)
  }

  save() { 
    if (this.form.valid) {
      this.form.controls.type.setValue(this.registerType);
      this.global.loadingSpinner();
      this.http.post(this.global.url + 'register', this.form.value)
        .toPromise()
        .then((data: DataResponse<any>) => {
          this.global.customLoading.dismiss();
          if(data['success']!=null){
            this.navCtrl.setRoot(ValidatPage, {mobile: this.form.controls.mobile.value, email: this.form.controls.email.value})
          }else if(data['error']!=null){
            this.global.alertMsg('error', 'mob_email');
          }
        })
        .catch(error => {
          this.global.customLoading.dismiss();
          console.log(error)
          this.global.alertMsg('error', 'server_error');
        });
    } else {
      this.global.validateAllFormFields(this.form);
    }
  }

}
