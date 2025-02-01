import { CommonModule } from '@angular/common';
import { TrendsComponent } from './../trends/trends.component';
import { Component, Input } from '@angular/core';
import { LikesComponent } from '../likes/likes.component';
import { RecipesComponent } from '../recipes/recipes.component';
import { RecipeCardComponent } from '../../shared/recipe-card/recipe-card.component';

@Component({
  selector: 'app-home-content',
  imports: [CommonModule, RecipesComponent, LikesComponent, TrendsComponent],
  templateUrl: './home-content.component.html',
  styleUrl: './home-content.component.scss'
})
export class HomeContentComponent {
  @Input() selectedSection: string = 'recipes';


}
