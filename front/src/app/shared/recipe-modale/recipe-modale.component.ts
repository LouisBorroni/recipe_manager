import { CommonModule } from '@angular/common';
import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-recipe-modale',
  imports: [CommonModule],
  templateUrl: './recipe-modale.component.html',
  styleUrl: './recipe-modale.component.scss'
})
export class RecipeModaleComponent {
  @Input() isVisible: boolean = false;  
  @Input() selectedRecipe: any;
  @Output() close = new EventEmitter<void>(); 

  closeModal() {
    this.close.emit();
  }
}
