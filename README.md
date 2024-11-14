# TinyPixel blog

---

## **Running the project**

### **Docker Run**

1. **Build and Start Services**:
   ```bash
   docker-compose up --build
   ```

2. **Access the Application**:
   Open your browser and go to: [http://localhost:8000](http://localhost:8000)

3. **Fill in the data**:
    - Before creating a blogpost you have to create an author.
    - Before creating a comment you have to have a blog post.
    - Authors that already have blogposts created under their `accounts` cannot be deleted

---
It's possible to run the project without docker. I have included `.htaccess` for this purpose as well. 

---

## **Notes**

- I have struggled a lot with the forms in the beginning. I'm sure there are better ways how to work with them, but this
  is the way I found, kind of understood and implemented.
- There may be better placement for the DTOs, but after reading multiple DDD vs. Symfony articles (not everybody agreed
  on their location) I figured this may be the best placement.
- Database has migrations but no seeders, so after spinning up the docker container the database is ready for work.
- The twigs were *mostly* made and then **beautified** using AI since the UI was not important, but I couldn't stand
  leaving it as plain html.
- The implementation of the dropdown in the form for blogpost creation was heavily discussed with ChatGPT, since
  approaches I tried did not work (initially I did the forms without DTOs - directly mapped to Models)
- I have opted to use UUIDs for the public data references. It may not be needed here, but I hate revealing sequential
  IDs, even though for performance issues they are still used as foreign keys and primary keys. They are not properly
  indexed here though.

---

## **Possible Improvements**

1. **Testing**:
    - I have not even started with unit tests.
    - I focused on making it properly and I have never tested symfony before, so I know im going to lose bonus points,
      but no tests for now.

2. **Code Quality and Quality of life**:
    - There are areas that deserve some love, such as verifying whether posts / users / authors exist during various actions.
    - SoftDeletes and/or cascades
    - Edits for comments, authors and blogs
    - More actions such as deleting comment authors and blog posts.

3. **Performance**:
    - Better Dockerfile with custom image
    - Optimized php/nginx/db settings
    - Caching (f.e.: Redis) for improved performance.

4. **Security**:
    - There is no auth, as the requirements did not require it, but it feels wrong not to do it.
    - No csrf protections
    - No xss protections (no html filtering for comments, names, titles, description, content, ...)

---

## **License**

*PixelLicense 1.1* - Free to use in non-commercial, commercial and imaginary scenarios.
