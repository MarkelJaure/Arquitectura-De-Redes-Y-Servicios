// Import the functions you need from the SDKs you need
import { initializeApp } from "firebase/app";
// TODO: Add SDKs for Firebase products that you want to use
// https://firebase.google.com/docs/web/setup#available-libraries

// Your web app's Firebase configuration
const firebaseConfig = {
  apiKey: "AIzaSyCkCMQSi6K_ZrsAlTSF7jL1GWLRgukL9ys",
  authDomain: "friendlychat-20790.firebaseapp.com",
  projectId: "friendlychat-20790",
  storageBucket: "friendlychat-20790.appspot.com",
  messagingSenderId: "521828797814",
  appId: "1:521828797814:web:36ea26514fb6383bab3e57"
};

const config = {
  apiKey: "AIzaSyCkCMQSi6K_ZrsAlTSF7jL1GWLRgukL9ys",
  authDomain: "friendlychat-20790.firebaseapp.com",
  projectId: "friendlychat-20790",
  storageBucket: "friendlychat-20790.appspot.com",
  messagingSenderId: "521828797814",
  appId: "1:521828797814:web:36ea26514fb6383bab3e57"
};

// Initialize Firebase
const app = initializeApp(firebaseConfig);

export function getFirebaseConfig() {
  if (!config || !config.apiKey) {
    throw new Error('No Firebase configuration object provided.' + '\n' +
      'Add your web app\'s configuration object to firebase-config.js');
  } else {
    return config;
  }
}

// var admin = require("firebase-admin");

// var serviceAccount = require("path/to/serviceAccountKey.json");

// admin.initializeApp({
//   credential: admin.credential.cert(serviceAccount)
// });

