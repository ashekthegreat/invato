(function () {
    // Initialize Firebase
    var config = {
        apiKey: "AIzaSyDJVeF-4v2ZBCu5sOz5mesxu113DXzP8c4",
        authDomain: "invato-53a3d.firebaseapp.com",
        databaseURL: "https://invato-53a3d.firebaseio.com",
        storageBucket: "invato-53a3d.appspot.com",
        messagingSenderId: "85880803011"
    };
    firebase.initializeApp(config);

    angular.module("invato", ["ui.router", "firebase"]);
}());
