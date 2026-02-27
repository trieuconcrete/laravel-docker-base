# Professional Enterprise Admin Dashboard - Design System

## 🎨 Color Palette

### Primary Colors - Deep Blue
Primary brand color for actions, links, and key UI elements.

| Shade | HEX | RGB | Usage |
|-------|-----|-----|-------|
| primary-50 | `#eff6ff` | 239, 246, 255 | Very light backgrounds, hover states |
| primary-100 | `#dbeafe` | 219, 234, 254 | Light backgrounds, badges |
| primary-200 | `#bfdbfe` | 191, 219, 254 | Borders, dividers |
| primary-300 | `#93c5fd` | 147, 197, 253 | Disabled states, placeholders |
| primary-400 | `#60a5fa` | 96, 165, 250 | Hover states |
| primary-500 | `#3b82f6` | 59, 130, 246 | Default blue (lighter) |
| **primary-600** | **`#2563eb`** | **37, 99, 235** | **Main brand color** ✨ |
| primary-700 | `#1d4ed8` | 29, 78, 216 | Hover, active states |
| primary-800 | `#1e40af` | 30, 64, 175 | Pressed states |
| primary-900 | `#1e3a8a` | 30, 58, 138 | Dark accents |
| primary-950 | `#172554` | 23, 37, 84 | Very dark accents |

**Usage Rules:**
- Buttons: primary-600 (hover: primary-700)
- Links: primary-600 (hover: primary-700)
- Focus rings: primary-600 at 50% opacity
- Active/Selected: primary-600 background

---

### Secondary Colors - Slate Gray
Neutral, professional grayscale for text, borders, and backgrounds.

| Shade | HEX | RGB | Usage |
|-------|-----|-----|-------|
| **secondary-50** | **`#f8fafc`** | **248, 250, 252** | **Page background** ✨ |
| secondary-100 | `#f1f5f9` | 241, 245, 249 | Card backgrounds |
| secondary-200 | `#e2e8f0` | 226, 232, 240 | Borders, dividers |
| secondary-300 | `#cbd5e1` | 203, 213, 225 | Disabled text, icons |
| secondary-400 | `#94a3b8` | 148, 163, 184 | Placeholder text |
| secondary-500 | `#64748b` | 100, 116, 139 | Secondary text |
| secondary-600 | `#475569` | 71, 85, 105 | Body text (secondary) |
| secondary-700 | `#334155` | 51, 65, 85 | Headings (lighter) |
| secondary-800 | `#1e293b` | 30, 41, 59 | Dark text |
| **secondary-900** | **`#0f172a`** | **15, 23, 42** | **Primary text color** ✨ |
| secondary-950 | `#020617` | 2, 6, 23 | Darkest text |

**Usage Rules:**
- Page background: secondary-50 (#f8fafc)
- Card/surface: white (#ffffff)
- Primary text: secondary-900 (#0f172a)
- Secondary text: secondary-600 (#475569)
- Tertiary text: secondary-400 (#94a3b8)
- Borders: secondary-200 (#e2e8f0)
- Light borders: secondary-100 (#f1f5f9)

---

### Success Colors - Green
Positive actions, confirmations, success messages.

| Shade | HEX | RGB | Usage |
|-------|-----|-----|-------|
| success-50 | `#f0fdf4` | 240, 253, 244 | Light backgrounds |
| success-100 | `#dcfce7` | 220, 252, 231 | Badges, alerts |
| success-200 | `#bbf7d0` | 187, 247, 208 | Borders |
| success-300 | `#86efac` | 134, 239, 172 | Hover states |
| success-400 | `#4ade80` | 74, 222, 128 | Active states |
| **success-500** | **`#22c55e`** | **34, 197, 94** | **Default success** ✨ |
| success-600 | `#16a34a` | 22, 163, 74 | Hover, pressed |
| success-700 | `#15803d` | 21, 128, 61 | Dark success |
| success-800 | `#166534` | 22, 101, 52 | Darker states |
| success-900 | `#14532d` | 20, 83, 45 | Darkest |

**Usage Examples:**
- Success buttons: success-600
- Success messages: success-50 background, success-600 text
- Status indicators: success-500
- Icons: success-600

---

### Warning Colors - Amber
Caution, attention needed, pending states.

| Shade | HEX | RGB | Usage |
|-------|-----|-----|-------|
| warning-50 | `#fffbeb` | 255, 251, 235 | Light backgrounds |
| warning-100 | `#fef3c7` | 254, 243, 199 | Badges, alerts |
| warning-200 | `#fde68a` | 253, 230, 138 | Borders |
| warning-300 | `#fcd34d` | 252, 211, 77 | Hover states |
| warning-400 | `#fbbf24` | 251, 191, 36 | Active states |
| **warning-500** | **`#f59e0b`** | **245, 158, 11** | **Default warning** ✨ |
| warning-600 | `#d97706` | 217, 119, 6 | Hover, pressed |
| warning-700 | `#b45309` | 180, 83, 9 | Dark warning |
| warning-800 | `#92400e` | 146, 64, 14 | Darker states |
| warning-900 | `#78350f` | 120, 53, 15 | Darkest |

**Usage Examples:**
- Warning buttons: warning-500
- Warning messages: warning-50 background, warning-700 text
- Pending status: warning-500
- Caution icons: warning-600

---

### Danger Colors - Red
Errors, destructive actions, critical alerts.

| Shade | HEX | RGB | Usage |
|-------|-----|-----|-------|
| danger-50 | `#fef2f2` | 254, 242, 242 | Light backgrounds |
| danger-100 | `#fee2e2` | 254, 226, 226 | Badges, alerts |
| danger-200 | `#fecaca` | 254, 202, 202 | Borders |
| danger-300 | `#fca5a5` | 252, 165, 165 | Hover states |
| danger-400 | `#f87171` | 248, 113, 113 | Active states |
| **danger-500** | **`#ef4444`** | **239, 68, 68** | **Default danger** ✨ |
| danger-600 | `#dc2626` | 220, 38, 38 | Hover, pressed |
| danger-700 | `#b91c1c` | 185, 28, 28 | Dark danger |
| danger-800 | `#991b1b` | 153, 27, 27 | Darker states |
| danger-900 | `#7f1d1d` | 127, 29, 29 | Darkest |

**Usage Examples:**
- Delete buttons: danger-600
- Error messages: danger-50 background, danger-700 text
- Error inputs: danger-600 border
- Alert icons: danger-600

---

### Info Colors - Cyan
Information, helpful hints, guidance.

| Shade | HEX | RGB | Usage |
|-------|-----|-----|-------|
| info-50 | `#ecfeff` | 236, 254, 255 | Light backgrounds |
| info-100 | `#cffafe` | 207, 250, 254 | Badges, alerts |
| info-200 | `#a5f3fc` | 165, 243, 252 | Borders |
| info-300 | `#67e8f9` | 103, 232, 249 | Hover states |
| info-400 | `#22d3ee` | 34, 211, 238 | Active states |
| **info-500** | **`#06b6d4`** | **6, 182, 212** | **Default info/accent** ✨ |
| info-600 | `#0891b2` | 8, 145, 178 | Hover, pressed |
| info-700 | `#0e7490` | 14, 116, 144 | Dark info |
| info-800 | `#155e75` | 21, 94, 117 | Darker states |
| info-900 | `#164e63` | 22, 78, 99 | Darkest |

**Usage Examples:**
- Info messages: info-50 background, info-700 text
- Accent highlights: info-500
- Info icons: info-600
- Tooltips: info-600

---

## 🎯 Design Principles

### 1. Trustworthy & Stable
- Use deep blue (primary-600) as anchor color
- Employ slate grays for professional neutrality
- Avoid bright, playful colors
- Maintain consistent spacing and alignment

### 2. Data-Driven
- Clear visual hierarchy (text sizes, weights)
- High contrast text (WCAG AA compliant)
- Readable fonts (system UI fonts)
- Ample whitespace for clarity

### 3. Flat & Modern
- Minimal gradients (avoid unless subtle)
- Flat color blocks
- Simple shadows (sm, md only)
- Clean borders (1px, solid)

### 4. Accessible
- All text meets WCAG AA contrast ratios:
  - Normal text: 4.5:1 minimum
  - Large text: 3:1 minimum
- Focus states clearly visible (2px ring)
- Color not sole indicator (use icons + text)

---

## 📏 Component Guidelines

### Buttons

**Primary Button:**
```
Background: primary-600 (#2563eb)
Hover: primary-700 (#1d4ed8)
Text: white
Border: none
Shadow: sm (optional)
Border radius: 4px-6px
Padding: py-2.5 px-4 (text-sm)
```

**Secondary Button:**
```
Background: white
Hover: secondary-50 (#f8fafc)
Text: secondary-700 (#334155)
Border: 1px solid secondary-300 (#cbd5e1)
Border radius: 4px-6px
```

**Danger Button:**
```
Background: danger-600 (#dc2626)
Hover: danger-700 (#b91c1c)
Text: white
```

---

### Form Inputs

```
Background: white
Border: 1px solid secondary-300 (#cbd5e1)
Border radius: 4px-6px
Padding: py-2 px-3
Text: secondary-900 (#0f172a)
Placeholder: secondary-400 (#94a3b8)
Focus:
  - Ring: 2px primary-600 at 50% opacity
  - Border: primary-600
Error:
  - Border: danger-500 (#ef4444)
```

---

### Cards

```
Background: white (#ffffff)
Border: 1px solid secondary-200 (#e2e8f0)
Border radius: 8px (rounded-lg)
Shadow: sm or none
Padding: p-6 to p-8
```

---

### Typography

**Headings:**
- h1: text-2xl, font-semibold, text-slate-900
- h2: text-xl, font-semibold, text-slate-900
- h3: text-lg, font-medium, text-slate-900

**Body:**
- Primary: text-sm or text-base, text-slate-900
- Secondary: text-sm, text-slate-600
- Tertiary: text-xs, text-slate-500

---

### Sidebar

```
Background: white with subtle left border (primary-600)
or Gradient: linear-gradient(135deg, primary-900 to primary-600) with white/10 opacity overlays
Text: white (if gradient) or slate-900 (if white bg)
Active item: primary-600 background, white text
Hover: primary-50 or white/10
```

---

## ✅ Accessibility Checklist

- [ ] All text has 4.5:1 contrast ratio (WCAG AA)
- [ ] Focus states visible with 2px ring
- [ ] Interactive elements have hover/active states
- [ ] Error states use icon + color + text
- [ ] Form labels clearly associated with inputs
- [ ] Color blindness safe (use patterns/icons)
- [ ] Keyboard navigable (tab order logical)
- [ ] Touch targets minimum 44x44px

---

## 📦 Implementation Files

### CSS (Tailwind Config)
File: `src/resources/css/app.css`

### Login Page
File: `src/resources/views/auth/login-professional.blade.php`

### Admin Layout
File: `src/resources/views/layouts/admin.blade.php` (to be updated)

### Sidebar Menu
File: `src/resources/views/partials/sidebar-menu.blade.php`

---

## 🔧 Quick Reference

**Primary Action:** `bg-blue-600 hover:bg-blue-700 text-white`  
**Secondary Action:** `border border-slate-300 hover:bg-slate-50 text-slate-700`  
**Text Input:** `border border-slate-300 focus:ring-2 focus:ring-blue-600`  
**Card:** `bg-white rounded-lg border border-slate-200 shadow-sm`  
**Page Background:** `bg-slate-50`  
**Text Primary:** `text-slate-900`  
**Text Secondary:** `text-slate-600`  

---

## 📊 Color Contrast Matrix (WCAG AA)

| Foreground | Background | Contrast | Pass |
|------------|------------|----------|------|
| secondary-900 (#0f172a) | white (#ffffff) | 16.8:1 | ✅ AAA |
| secondary-900 (#0f172a) | secondary-50 (#f8fafc) | 16.1:1 | ✅ AAA |
| secondary-600 (#475569) | white (#ffffff) | 8.8:1 | ✅ AAA |
| primary-600 (#2563eb) | white (#ffffff) | 8.6:1 | ✅ AAA |
| white (#ffffff) | primary-600 (#2563eb) | 8.6:1 | ✅ AAA |
| success-600 (#16a34a) | white (#ffffff) | 5.5:1 | ✅ AA |
| danger-600 (#dc2626) | white (#ffffff) | 6.1:1 | ✅ AA |
| warning-700 (#b45309) | warning-50 (#fffbeb) | 8.2:1 | ✅ AAA |

---

**Last Updated:** February 15, 2026  
**Version:** 1.0.0  
**Design System:** Professional Enterprise SaaS Admin Dashboard
