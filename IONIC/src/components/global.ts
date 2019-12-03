import { Injectable } from '@angular/core';
import { HttpHeaders } from '@angular/common/http';
import { LoadingController, AlertController } from 'ionic-angular';
import { TranslateService } from '@ngx-translate/core';
import { FormGroup, FormControl } from '@angular/forms';

@Injectable()

export class Global {
  url: string = 'http://mykaraj.3wmaker.com/public/api/';
  imagePath: string = 'http://mykaraj.3wmaker.com/public/content/';


  // url: string = 'http://localhost:8000/api/';

  

  lang: string = 'en';
  dirction: string = 'ltr';
  align: string = 'left';
  otherDirction: string = 'rtl';
  otherAlign: string = 'right';

  noheader = new HttpHeaders({});
  oauthHeader = new HttpHeaders({ Authorization: "Bearer " + localStorage.getItem("token") });

  customLoading: any;
  
  constructor(
    public loading: LoadingController,
    public alertCtrl: AlertController,
    public translate: TranslateService) { }

  loadingSpinner() {
    this.customLoading = this.loading.create({
      spinner: "ios"
    });
    this.customLoading.present();
  }

  alertMsg(title: any, message: any) {
    let alert = this.alertCtrl.create({
      title: this.translate.instant(title),
      subTitle: '',
      message: this.translate.instant(message),
      buttons: [this.translate.instant('okay')],
      enableBackdropDismiss: true
    });
    alert.present();
  }

  validateAllFormFields(formGroup: FormGroup) {
    Object.keys(formGroup.controls).forEach(field => {
      const control = formGroup.get(field);
      if (control instanceof FormControl) {
        control.markAsTouched({ onlySelf: true });
      } else if (control instanceof FormGroup) {
        this.validateAllFormFields(control);
      }
    });
  }
}
