// src/app/store/user.selectors.ts
import { createFeatureSelector, createSelector } from '@ngrx/store';
import { UserState } from './user.reducer';

// Créer un feature selector pour accéder à l'état utilisateur
export const selectUserState = createFeatureSelector<UserState>('user');

// Créer un selector pour récupérer l'utilisateur
export const selectUser = createSelector(
  selectUserState,
  (state: UserState) => state.user
);
