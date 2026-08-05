// Entrance Animation Observer (Intersection Observer API)
document.addEventListener('alpine:init', () => {
  Alpine.data('fadeIn', () => ({
    init() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      
      observer.observe(this.$el);
    }
  }));
  
  Alpine.data('slideUp', () => ({
    init() {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('animate-slide-up');
            observer.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      
      observer.observe(this.$el);
    }
  }));
  
  // Stagger animation for lists
  Alpine.data('stagger', (delay = 100) => ({
    init() {
      const children = this.$el.children;
      Array.from(children).forEach((child, index) => {
        child.style.animationDelay = `${index * delay}ms`;
        child.classList.add('animate-fade-in');
      });
    }
  }));
  
  // Dark mode store (PREP - not activated in UI yet)
  Alpine.store('darkMode', {
    on: false,
    
    init() {
      this.on = localStorage.getItem('darkMode') === 'true' || 
                (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches);
      this.updateDOM();
    },
    
    toggle() {
      this.on = !this.on;
      localStorage.setItem('darkMode', this.on);
      this.updateDOM();
    },
    
    updateDOM() {
      if (this.on) {
        document.documentElement.classList.add('dark');
      } else {
        document.documentElement.classList.remove('dark');
      }
    }
  });
});
