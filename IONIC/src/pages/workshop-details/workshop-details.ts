import { Component, ViewChild, ElementRef } from '@angular/core';
import { NavController, NavParams, Platform } from 'ionic-angular';
import { WorkshopPage } from '../workshop/workshop';
import { Global } from '../../components/global';
import { HttpClient } from '@angular/common/http';
import { DataResponse } from '../../components/DataResponse';
import { Subscription } from 'rxjs';
import { Geolocation } from '@ionic-native/geolocation';
import { HomePage } from '../home/home';

/**
 * Generated class for the WorkshopDetailsPage page.
 *
 * See https://ionicframework.com/docs/components/#navigation for more info on
 * Ionic pages and navigation.
 */

declare var google;

@Component({
  selector: 'page-workshop-details',
  templateUrl: 'workshop-details.html',
})
export class WorkshopDetailsPage {
  @ViewChild('mapservice') mapElement: ElementRef;
  @ViewChild('directionsPanel') directionsPanel: ElementRef;
  map: any;
  postionSubscription: Subscription;

  karajId: any;
  karajInfo: any = [];
  imageLogo: any;
  viewRate: any;
  openDetails: boolean = false;
  location: boolean = false;
  contact: boolean = false;
  fullBG: boolean = false;
  car: boolean = false;
  carList: any = [];

  showDirection: boolean;


  constructor(public navCtrl: NavController,
    public navParams: NavParams,
    public global: Global,
    public http: HttpClient,
    public geolocation: Geolocation,
    public platform: Platform) {
    this.karajId = navParams.get('id');
  }

  ionViewDidLoad() {
    this.load();
    this.showDirection = false;

  }

  goBack() {
    this.navCtrl.setRoot(WorkshopPage)
  }

  load() {
    this.global.loadingSpinner();
    console.log(this.global.url + 'details/' + this.karajId)
    this.http.get(this.global.url + 'details/' + this.karajId)
      .toPromise()
      .then((result: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        if (result.error == 'success') {
          this.karajInfo = result.data;
          console.log(this.karajInfo);
          this.imageLogo = this.global.imagePath + this.karajInfo.logo;
          this.viewRate = localStorage.getItem('rate');
          if (localStorage.getItem('fees') == 'Free') {
            this.openDetails = true;
          }
          if (localStorage.getItem('payment') == 'complete') {
            this.openDetails = true;
          }
        } else {
          this.global.alertMsg('error', 'server_error');
        }
      })
      .catch((error: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }

  save(carId: any) {
    this.closeFaseBox();
    this.global.loadingSpinner();
    this.http.post(this.global.url + 'booking', { carId: carId, workshopId: this.karajId }, { headers: this.global.oauthHeader })
      .toPromise()
      .then((data: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        if (data.error == 'success') {
          this.global.alertMsg('success', 'booking_success');
          this.navCtrl.setRoot(HomePage);
        } else {
          this.global.alertMsg('error', 'server_error');
        }
      })
      .catch((error: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }

  getCarsList() {
    this.global.loadingSpinner();
    this.http.get(this.global.url + 'car-list', { headers: this.global.oauthHeader })
      .toPromise()
      .then((data: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        if (data.error == 'no_data_found') {
          this.carList = '';
        } else if (data.error == 'success') {
          this.fullBG = true;
          this.car = true;
          this.carList = data.data;
        }
      })
      .catch((error: DataResponse<any>) => {
        this.global.customLoading.dismiss();
        console.log(error)
        this.global.alertMsg('error', 'server_error');
      });
  }

  openLocation() {
    if (!this.openDetails) {
      this.global.alertMsg('alert', 'make_book');
    } else {
      this.fullBG = true;
      this.location = true;

      let latitude = parseFloat(this.karajInfo.google_lat);
      let longitude = parseFloat(this.karajInfo.google_lng);
      if (document.getElementById('mapservice') === null || typeof (document.getElementById('mapservice')) === 'undefined') {
        setTimeout(() => {
          this.openLocation();
        }, 500);
      } else {
        this.map = new google.maps.Map(document.getElementById('mapservice'), {
          center: { lat: latitude, lng: longitude },
          zoom: 17
        });

        this.startNavigating();

        var position = new google.maps.LatLng(latitude, longitude);
        var museumMarker = new google.maps.Marker({ position: position, title: this.karajInfo.en_name });
        museumMarker.setMap(this.map);
      }
    }
    this.showDirection = true;
  }

  getMapElement() {
    if (document.getElementById('mapservice') === null || typeof (document.getElementById('mapservice')) === 'undefined') {
      setTimeout(() => {
        this.getMapElement();
      }, 500);
    } else {
      return document.getElementById('mapservice');
    }
  }

  openContent() {
    if (!this.openDetails) {
      this.global.alertMsg('alert', 'make_book');
    } else {
      this.fullBG = true;
      this.contact = true;
    }
  }



  closeFaseBox() {
    this.fullBG = false;
    this.contact = false;
    this.location = false;
    this.car = false;
  }

  startNavigating() {
    this.geolocation.getCurrentPosition().then((position) => {
      let latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

      let directionsService = new google.maps.DirectionsService;
      let directionsDisplay = new google.maps.DirectionsRenderer;

      directionsDisplay.setMap(this.map);
      // directionsDisplay.setPanel(this.directionsPanel.nativeElement);

      let start = latLng;
      let end = new google.maps.LatLng(parseFloat(this.karajInfo.google_lat), parseFloat(this.karajInfo.google_lng));

      directionsService.route({
        origin: start,
        destination: end,
        travelMode: google.maps.TravelMode['DRIVING']
      }, (res, status) => {

        if (status == google.maps.DirectionsStatus.OK) {
          directionsDisplay.setDirections(res);
        } else {
          console.warn(status);
        }

      });

    }, (err) => {
      console.log(err);
    });


    // let directionsService = new google.maps.DirectionsService;
    // let directionsDisplay = new google.maps.DirectionsRenderer;

    // directionsDisplay.setMap(this.map);
    // directionsDisplay.setPanel(this.directionsPanel.nativeElement);

    // directionsService.route({
    //   origin: 'Moscow',
    //   destination: 'Krasnodar',
    //   travelMode: google.maps.TravelMode['DRIVING']
    // }, (res, status) => {

    //   if (status == google.maps.DirectionsStatus.OK) {
    //     directionsDisplay.setDirections(res);
    //   } else {
    //     console.warn(status);
    //   }

    // });
  }


}
