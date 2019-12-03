import { Component } from '@angular/core';
import { NavController, AlertController, Platform } from 'ionic-angular';
import { HttpClient } from '@angular/common/http';
import { Global } from '../../components/global';
import { LoginPage } from '../login/login';
import { DataResponse } from '../../components/DataResponse';
import { CategoryPage } from '../category/category';
import { ChangePassPage } from '../change-pass/change-pass';
import { CarPage } from '../car/car';
import { TranslateService } from '@ngx-translate/core';
import { Camera, CameraOptions } from '@ionic-native/camera';
import { WorkshopInfoPage } from '../workshop-info/workshop-info';

import { Push, PushObject, PushOptions } from '@ionic-native/push';



@Component({
  selector: 'page-home',
  templateUrl: 'home.html'
})
export class HomePage {
  content: string;
  showMenu: boolean = false;
  showUpload: boolean = false;
  userName: string = '';
  userImg: string = '';
  userType: string = '';
  base64Image: any;

  constructor(public navCtrl: NavController,
    public http: HttpClient,
    public global: Global,
    public translate: TranslateService,
    public alertCtrl: AlertController,
    private platform: Platform,
    private push: Push,
    public camera: Camera) {
    localStorage.setItem('pageTitle', 'services');
    this.getToken();
  }

  getToken() {
    let token;
    const options: PushOptions = {
      android: {},
      ios: {
        alert: 'true',
        badge: true,
        sound: 'false'
      },
      windows: {},
      browser: {
        pushServiceURL: 'http://push.api.phonegap.com/v1/push'
      }
    };

    const pushObject: PushObject = this.push.init(options);
    this.push.init(options).on('registration').subscribe((registration: any) => {
      console.log('push notification');
      console.log('Device registered', registration)
      // "e67Q_j_2rmA:APA91bGFh47jiO3oRLiNSPjh8GsMKPu6tuuoB0Lo-DqR8w7BDUrbCFDvsStZLhyZP6g44Q8A9N6cgzX5DmQqCBXvYT5hT0fAVHfwpkNVW3KhM77UvvRumFtvRMAgF457igbxC0Cvj398"
    });

    console.log("qqqqqqqqqqqqqqqqqqqqqq", token)
  }


  ionViewDidLoad() {
    this.load();
  }

  load() {
    this.global.loadingSpinner();
    this.http.get(this.global.url + 'services', {
      headers: this.global.noheader
    })
      .toPromise()
      .then((result: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        if (result.error == '200') {
          this.content = result.data;
        } else {
          this.global.alertMsg('error', 'server_400');
        }
      })
      .catch((error: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }

  getSub(item: any) {
    this.navCtrl.setRoot(CategoryPage, { item: item });
  }

  openMenu() {
    if (localStorage.getItem('token')) {
      this.userName = localStorage.getItem('name');
      this.userImg = localStorage.getItem('image');
      this.userType = localStorage.getItem('userType');
      this.showMenu = true;
    } else {
      localStorage.setItem('comFrom', 'home');
      this.navCtrl.setRoot(LoginPage);
    }
  }

  closeMenu() {
    this.showMenu = false;
    this.showUpload = false;
  }

  closeUpload() {
    this.showUpload = false;
  }

  logout() {
    this.showUpload = false;
    const alert = this.alertCtrl.create({
      title: this.translate.instant('logout'),
      message: this.translate.instant('logout-confirm-msg'),
      buttons: [
        {
          text: this.translate.instant('close')
        }, {
          text: this.translate.instant('logout-btn'),
          cssClass: 'logout',
          handler: () => {
            localStorage.removeItem('token');
            localStorage.removeItem('image');
            localStorage.removeItem('name');
            localStorage.removeItem('userType');
            this.showMenu = false;
          }
        }
      ]
    });
    alert.present();
  }

  changePass() {
    this.navCtrl.setRoot(ChangePassPage);
  }

  myCars() {
    this.navCtrl.setRoot(CarPage);
  }

  uploadProfileImg() {
    this.showUpload = true;
  }

  openCamera() {
    const options: CameraOptions = {
      quality: 70,
      destinationType: this.camera.DestinationType.DATA_URL,
      encodingType: this.camera.EncodingType.JPEG,
      mediaType: this.camera.MediaType.PICTURE,
    }
    this.camera.getPicture(options).then((imageData) => {
      this.base64Image = 'data:image/jpeg;base64,' + imageData;
      this.uploadImage();
    }, (err) => {
      this.global.alertMsg('error', err);
    });
  }

  openGallery() {
    this.camera.getPicture({
      sourceType: this.camera.PictureSourceType.SAVEDPHOTOALBUM,
      destinationType: this.camera.DestinationType.DATA_URL
    }).then((imageData) => {
      this.base64Image = 'data:image/jpeg;base64,' + imageData;
      this.uploadImage();
    }, (err) => {
      this.global.alertMsg('error', err);
    });
  }

  uploadImage() {
    this.global.loadingSpinner();
    this.http.post(this.global.url + 'upload-profile', { image: this.base64Image }, { headers: this.global.oauthHeader })
      .toPromise()
      .then((result: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        localStorage.setItem('image', this.global.imagePath + result.data);
        this.navCtrl.setRoot(HomePage);
      })
      .catch((error: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        this.global.alertMsg('error', error);
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }

  garageInfo() {
    this.navCtrl.setRoot(WorkshopInfoPage);
  }

}
