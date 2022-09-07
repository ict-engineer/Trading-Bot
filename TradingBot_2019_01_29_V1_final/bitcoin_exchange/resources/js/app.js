require('./bootstrap');

import React from 'react';
import { render } from 'react-dom';
import { Router, Route, browserHistory } from 'react-router';
import Master from './components/Master';
import { BrowserRouter } from 'react-router-dom'
render(<BrowserRouter><Master /></BrowserRouter>, document.getElementById('example'));
