import { ApplicationConfig, importProvidersFrom, provideZoneChangeDetection } from '@angular/core';
import { provideRouter } from '@angular/router';

import { appRoutes } from './app.routes';
import { provideClientHydration, withEventReplay } from '@angular/platform-browser';
import { FormsModule } from '@angular/forms';
import { provideHttpClient } from '@angular/common/http';
import { provideStore } from '@ngrx/store';
import { CommonModule } from '@angular/common';
import { userReducer } from './stores/user/user.reducer';
import { provideStoreDevtools } from '@ngrx/store-devtools';



export const appConfig: ApplicationConfig = {
  providers: [
    provideZoneChangeDetection({ eventCoalescing: true }), 
    provideRouter(appRoutes), 
    provideClientHydration(withEventReplay()), 
    provideHttpClient(),
    importProvidersFrom(FormsModule, CommonModule),
    provideStore({ user: userReducer }),
    provideStoreDevtools({ maxAge: 25, autoPause: true, trace: false }),
  ]
};
