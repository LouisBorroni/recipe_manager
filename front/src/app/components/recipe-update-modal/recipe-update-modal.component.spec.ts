import { ComponentFixture, TestBed } from '@angular/core/testing';

import { RecipeUpdateModalComponent } from './recipe-update-modal.component';

describe('RecipeUpdateModalComponent', () => {
  let component: RecipeUpdateModalComponent;
  let fixture: ComponentFixture<RecipeUpdateModalComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [RecipeUpdateModalComponent]
    })
    .compileComponents();

    fixture = TestBed.createComponent(RecipeUpdateModalComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
