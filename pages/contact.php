<h1>Contact Us</h1>

<form id="contact-form" method="post" action="submit_contact.php">
    <input type="text" name="name" placeholder="Your Name" required>
    <input type="email" name="email" placeholder="Your Email" required>
    <select name="subject">
        <option value="general">General Inquiry</option>
        <option value="recipe">Recipe Request</option>
        <option value="feedback">Feedback</option>
    </select>
    <textarea name="message" placeholder="Your Message" required></textarea>
    <button type="submit">Send Message</button>
</form>