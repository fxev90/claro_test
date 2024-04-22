import {ComponentFixture, TestBed, waitForAsync} from '@angular/core/testing';
import {CursoComponent} from './curso.component';

describe('BlankComponent', () => {
    let component: CursoComponent;
    let fixture: ComponentFixture<CursoComponent>;

    beforeEach(waitForAsync(() => {
        TestBed.configureTestingModule({
            declarations: [CursoComponent]
        }).compileComponents();
    }));

    beforeEach(() => {
        fixture = TestBed.createComponent(CursoComponent);
        component = fixture.componentInstance;
        fixture.detectChanges();
    });

    it('should create', () => {
        expect(component).toBeTruthy();
    });
});
