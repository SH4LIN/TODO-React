import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import ToDo from './App';
import reportWebVitals from './reportWebVitals';

// Creating a root for the app.
const root = ReactDOM.createRoot(document.getElementById('root'));
// Rendering the ToDo Component.
root.render(
  <React.StrictMode>
    <ToDo />
  </React.StrictMode>
);

// If you want to start measuring performance in your app, pass a function
// to log results (for example: reportWebVitals(console.log))
// or send to an analytics endpoint. Learn more: https://bit.ly/CRA-vitals
reportWebVitals();
