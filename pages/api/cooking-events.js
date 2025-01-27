import { pool } from '../../lib/db';

export default async function handler(req, res) {
  if (req.method !== 'GET') {
    return res.status(405).json({ message: 'Method not allowed' });
  }

  try {
    const client = await pool.connect();
    const result = await client.query(
      'SELECT * FROM cooking_events WHERE event_date > NOW() ORDER BY event_date ASC LIMIT 10'
    );
    client.release();
    
    res.status(200).json(result.rows);
  } catch (error) {
    console.error('Error fetching cooking events:', error);
    res.status(500).json({ message: 'Internal server error' });
  }
} 