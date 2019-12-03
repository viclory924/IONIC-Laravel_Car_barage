import { Component, ViewChild, ElementRef, transition } from '@angular/core';
import { NavController, NavParams } from 'ionic-angular';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { DataResponse } from '../../components/DataResponse';
import { HomePage } from '../home/home';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { CameraOptions, Camera } from '@ionic-native/camera';
import { Geolocation } from '@ionic-native/geolocation';
import { GoogleMap, LatLng } from '@ionic-native/google-maps';
import { HttpHeaders } from '@angular/common/http';


/**
 * Generated class for the WorkshopInfoPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

declare var google;

@Component({
  selector: 'page-workshop-info',
  templateUrl: 'workshop-info.html',
})
export class WorkshopInfoPage {

  @ViewChild('map') mapElement: ElementRef;
  map: any;


  garageLang: string = '';
  garageInfo: any = [];
  form: FormGroup;
  showUpload: boolean = false;
  base64Image: any;
  countryList: any = [];
  cityList: any = [];
  categoryList: any = [];
  subCategoryList: any = [];
  allSubCategoryList: any = [];
  latitude: any = '';
  longitude: any = '';

  newPos: LatLng;

  validation_messages = {
    'ar_name': [
      { type: 'required', message: 'required' }
    ],
    'en_name': [
      { type: 'required', message: 'required' }
    ],
    'country_id': [
      { type: 'required', message: 'required' }
    ],
    'city_id': [
      { type: 'required', message: 'required' }
    ],
    'en_address': [
      { type: 'required', message: 'required' }
    ],
    'ar_address': [
      { type: 'required', message: 'required' }
    ],
    'mobile': [
      { type: 'required', message: 'required' }
    ],
    'category_id': [
      { type: 'required', message: 'required' }
    ],
    'sub_cat_id': [
      { type: 'required', message: 'required' }
    ],
    'start_from': [
      { type: 'required', message: 'required' }
    ],
    'end_at': [
      { type: 'required', message: 'required' }
    ],
    'ar_description': [
      { type: 'required', message: 'required' }
    ],
    'en_description': [
      { type: 'required', message: 'required' }
    ]
  };

  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public global: Global,
    public formBuilder: FormBuilder,
    public camera: Camera,
    public http: HttpClient,
    public geolocation: Geolocation) {
  }

  ngOnInit() {
    this.form = this.formBuilder.group({
      ar_name: [null, Validators.required],
      en_name: [null, Validators.required],
      ar_description: [null, null],
      en_description: [null, null],
      country_id: [null, Validators.required],
      city_id: [null, Validators.required],
      ar_address: [null, Validators.required],
      en_address: [null, Validators.required],
      mobile: [null, Validators.required],
      telephone: [null, null],
      email: [null, null],
      website: [null, null],
      category_id: [null, Validators.required],
      sub_cat_id: [null, Validators.required],
      start_from: [null, Validators.required],
      end_at: [null, Validators.required],
    });
  }

  ionViewDidLoad() {
    this.garageLang = this.global.lang;
    this.load();
  }

  loadMap() {
    console.log("loadMap func is called----------------------------");

    let lat = localStorage.getItem('latitude');
    let lng = localStorage.getItem('longitude');

    if (lat !== null && typeof (lat) !== 'undefined') {
      let latLng = new google.maps.LatLng(parseFloat(lat), parseFloat(lng));
      let mapOptions = {
        center: latLng,
        zoom: 15,
        mapTypeId: google.maps.MapTypeId.ROADMAP
      }
      this.map = new google.maps.Map(this.mapElement.nativeElement, mapOptions);
      this.saveLocation();
      this.addMarker(this.map, lat, lng);
    } else {
      this.geolocation.getCurrentPosition().then((position) => {
        let latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
        let mapOptions = {
          center: latLng,
          zoom: 15,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        }
        this.map = new google.maps.Map(this.mapElement.nativeElement, mapOptions);
        this.saveLocation();
        this.addMarker(this.map, this.garageInfo.google_lat, this.garageInfo.google_lng);
      }, (err) => {
        console.log(err);
      });
    }
  }

  addMarker(map: any, lat, lng) {
    let marker = new google.maps.Marker({
      map: this.map,
      animation: google.maps.Animation.DROP,
      position: new google.maps.LatLng(parseFloat(lat), parseFloat(lng)),
      title: "Latitude" + lat + "| Longitude" + lng
    });

    google.maps.event.addListener(map, 'click', function (event) {
      this.newPos = new google.maps.LatLng(event.latLng.lat(), event.latLng.lng());
      marker.setPosition(new google.maps.LatLng(event.latLng.lat(), event.latLng.lng()));
      console.log(event.latLng.lat());
      localStorage.setItem('latitude', event.latLng.lat());
      localStorage.setItem('longitude', event.latLng.lng());
    })

  }

  saveLocation() {
    let lat = localStorage.getItem('latitude');
    let lng = localStorage.getItem('longitude');
    if (typeof (lat) !== 'undefined' && lat !== null) {
      localStorage.removeItem('latitude');
      localStorage.removeItem('longitude');
      this.http.post(this.global.url + 'save-workshop-place',
        {
          latitude: lat,
          longitude: lng
        },
        { headers: this.global.oauthHeader })
        .toPromise()
        .then()
        .catch((error: any) => {
          console.log('Error getting location', error);
        });
    }
  }



  load() {
    this.global.loadingSpinner();
    this.http.get(this.global.url + 'garage-info', { headers: new HttpHeaders({ Authorization: "Bearer " + localStorage.getItem("token") }) })
      .toPromise()
      .then((data: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        if (data.error == 'success') {
          // if (data.data != null) {
          this.garageInfo = data.data;
          this.cityList = data.cityList;
          this.countryList = data.countryList;
          this.categoryList = data.categoryList;
          this.allSubCategoryList = data.subCategoryList;
          console.log(this.garageInfo.google_lat);
          // }
        } else {
          this.global.alertMsg('error', 'server_error');
        }
        this.loadMap();
      })
      .catch(error => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }

  changeCity(country: string): void {

  }

  changeSubCategory(cat: string): void {
    this.subCategoryList = this.allSubCategoryList.filter(item => item.cat_id == cat)
  }

  goBack() {
    this.navCtrl.setRoot(HomePage);
  }

  save() {

    if (this.form.valid) {
      this.global.loadingSpinner();

      // this.newPos
      this.http.post(this.global.url + 'save-workshop-data', this.form.value, { headers: this.global.oauthHeader })
        .toPromise()
        .then((data: DataResponse<any>) => {
          console.log("response data--------------", data)
          this.global.customLoading.dismiss();
          this.navCtrl.setRoot(WorkshopInfoPage);
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

  uploadImg(id: any) {
    this.showUpload = true;
  }

  closeUpload() {
    this.showUpload = false;
  }

  openCamera() {
    const options: CameraOptions = {
      quality: 70,
      destinationType: this.camera.DestinationType.DATA_URL,
      encodingType: this.camera.EncodingType.JPEG,
      mediaType: this.camera.MediaType.PICTURE,
      targetWidth: 300,
      targetHeight: 300,
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
    this.http.post(this.global.url + 'upload-workshop-image/', { image: this.base64Image }, { headers: this.global.oauthHeader })
      .toPromise()
      .then((result: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        this.navCtrl.setRoot(WorkshopInfoPage);
      })
      .catch((error: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }



}
